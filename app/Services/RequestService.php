<?php


namespace App\Services;


use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Jobs\SaveCollectionRequestDetailsJob;
use App\Request;
use App\Services\Admin\CollectionRequestService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class RequestService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 25, 2020
 * @project   reloop
 */
class RequestService extends BaseService
{
    /**
     * Property: model
     *
     * @var Request
     */
    private $model;
    /**
     * Property: order_number
     *
     * @var string
     */
    private $request_number;
    /**
     * Property: userSubscriptionService
     *
     * @var UserSubscriptionService
     */
    private $userSubscriptionService;
    /**
     * Property: collectionRequestService
     *
     * @var CollectionRequestService
     */
    private $collectionRequestService;

    /**
     * RequestService constructor.
     * @param Request $model
     */
    public function __construct(Request $model,
                                CollectionRequestService $collectionRequestService,
                                UserSubscriptionService $userSubscriptionService)
    {
        parent::__construct();
        $this->model = $model;
        $this->userSubscriptionService = $userSubscriptionService;
        $this->collectionRequestService = $collectionRequestService;
    }

    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: collectionRequest
     *
     * @param IForm $collectionRequestForm
     *
     * @return array
     */
    public function collectionRequest(IForm $collectionRequestForm)
    {
        if($collectionRequestForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $collectionRequestForm->errors()
            );
        }

        $material_categories = App::make(MaterialCategoryService::class)->findMaterialCategoryById($collectionRequestForm->material_categories);
        if(!$material_categories->isEmpty()) {
            $request_number = 'RE'.strtotime(now());
            $saveData = [
                'material_category_details' => $material_categories,
                'collection_form_data' => $collectionRequestForm,
                'user_id' => auth()->id(),
                'request_number' => $request_number
            ];
            $checkUserTrips = App::make(UserSubscriptionService::class)->checkUserTrips($saveData);
            if ($checkUserTrips) {
                $availableDrivers = $this->collectionRequestService->driversAvailability(
                    $collectionRequestForm->collection_date, auth()->id(),
                    $collectionRequestForm->city_id, $collectionRequestForm->district_id
                );
                if ($availableDrivers['status'] == true) {
                    $extraCharge = false;
                    if (!empty($collectionRequestForm->card_number)) {

                        $stripeService = new StripeService();
                        $makePayment = $stripeService->buyPlan($collectionRequestForm);
                        if (array_key_exists('stripe_error', $makePayment)) {

                            return ResponseHelper::responseData(
                                Config::get('constants.ORDER_FAIL'),
                                IResponseHelperInterface::FAIL_RESPONSE,
                                false,
                                $makePayment
                            );
                        }
                        $extraCharge = true;
                    }

                    if ($extraCharge) {

                        $saveData['extra_charge'] = $collectionRequestForm->total;
                    }
                    SaveCollectionRequestDetailsJob::dispatch($saveData);

                    return ResponseHelper::responseData(
                        Config::get('constants.COLLECTION_SUCCESSFUL'),
                        IResponseHelperInterface::SUCCESS_RESPONSE,
                        true,
                        [
                            'collection_request' => [
                                $request_number
                            ],
                        ]
                    );
                } else {
                    return ResponseHelper::responseData(
                        $availableDrivers['message'],
                        $availableDrivers['code'],
                        $availableDrivers['status'],
                        [
                            "DriverNotAvailable" => [
                                $availableDrivers['message']
                            ]
                        ]
                    );
                }
            }
            return ResponseHelper::responseData(
                Config::get('constants.USER_TRIPS_FAIL'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                [
                    "InvalidTrips" => [
                        Config::get('constants.USER_TRIPS_FAIL')
                    ]
                ]
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }

    /**
     * Method: afterCollectionRequest
     *
     * @param $data
     *
     * @return void
     */
    public function afterCollectionRequest($data)
    {
        $updateTrips = App::make(UserSubscriptionService::class)->updateTrips($data);
        if($updateTrips){

            if(array_key_exists('extra_charge', $data)){

                $extraCharge = App::make(TransactionService::class)->extraCharge($data);
            }
            $updateTripsAfterRequest = App::make(UserService::class)->updateTripsAfterRequest($data);
            $saveRequestDetails = $this->create($data);
            $saveRequestCollectionDetails = App::make(RequestCollectionService::class)->create($data, $saveRequestDetails->id);
        }
    }

    /**
     * Method: create
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($data)
    {
        $city = App::make(CityService::class)->findById($data['collection_form_data']->city_id);
        $district = App::make(DistrictService::class)->findById($data['collection_form_data']->district_id);

        $model = $this->model;
        $model = $model->create([
            'user_id' => $data['user_id'],
            'request_number'  => $data['request_number'],
            'collection_date' => $data['collection_form_data']->collection_date,
            'collection_type' => $data['collection_form_data']->collection_type,
            'reward_points'   => null,
            'first_name' => $data['collection_form_data']->first_name ?? null,
            'last_name' => $data['collection_form_data']->last_name ?? null,
            'organization_name' => $data['collection_form_data']->organization_name ?? null,
            'phone_number' => $data['collection_form_data']->phone_number,
            'location' => $data['collection_form_data']->location,
            'latitude' => $data['collection_form_data']->latitude,
            'longitude' => $data['collection_form_data']->longitude,
            'city_id' => $city->id,
            'district_id' => $district->id,
            'street' => $data['collection_form_data']->street,
            'question_1' => $data['collection_form_data']->questions[0]['ques'],
            'answer_1' => $data['collection_form_data']->questions[0]['ans'],
            'question_2' => $data['collection_form_data']->questions[1]['ques'],
            'answer_2' => $data['collection_form_data']->questions[1]['ans'],
            'user_comments' => $data['collection_form_data']->user_comments,
        ]);
        return $model->fresh();
    }

    public function userCollectionRequests()
    {
        return $this->model->with([
            'requestCollection' => function($query){
                return $query->with([
                    'materialCategory' => function($subQuery){
                        return $subQuery->select('id', 'name', 'unit');
                    }
                ]);
            }, 'city', 'district'
        ])->where('user_id', auth()->id())->get();
    }

    /**
     * Method: assignedRequests
     *
     * @param $driverId
     * @param null $date
     *
     * @return Request[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function assignedRequests($driverId, $date=null)
    {
        $assignedTrips = $this->model->with([
            'requestCollection' => function ($query){
                return $query->with([
                    'materialCategory' => function($subQuery){
                        return $subQuery->select('id', 'name', 'unit');
                    }
                ]);
            }, 'city', 'district'
        ]);
        if(!empty($date)){

            return $assignedTrips->where(['driver_id' => $driverId, 'collection_date' => $date])->get();
        }
        return $assignedTrips->where('driver_id', $driverId)->get();
    }

    /**
     * Method: additionalComments
     *
     * @param $data
     *
     * @return void
     */
    public function additionalComments($data)
    {
        $additionalComments = $this->findById($data->request_id);
        if($additionalComments){

            $additionalComments->additional_comments = $data->additional_comments;
            $additionalComments->update();
        }
    }

    /**
     * Method: updateRequestStatus
     *
     * @param $requestId
     *
     * @return array
     */
    public function updateRequestStatus($requestId, $statusType)
    {
        $findRequest = $this->findById($requestId);
        if($findRequest){

            if($statusType == IOrderStatusType::TRIP_INITIATED){

                $findRequest->status = IOrderStaus::DRIVER_DISPATCHED;
                $findRequest->driver_trip_status = IDriverTripStatus::TRIP_INITIATED;

                App::make(OneSignalNotificationService::class)->oneSignalNotificationService(
                    $findRequest->user_id, Config::get('constants.DRIVER_TRIP_INITIATED'), $findRequest->request_number
                );
            } elseif ($statusType == IOrderStatusType::TRIP_COMPLETED){

                $findRequest->status = IOrderStaus::ORDER_COMPLETED;
                $findRequest->driver_trip_status = IDriverTripStatus::TRIP_COMPLETED;

                App::make(OneSignalNotificationService::class)->oneSignalNotificationService(
                    $findRequest->user_id, Config::get('constants.DRIVER_TRIP_ENDED'), $findRequest->request_number
                );
            }
            $findRequest->update();

            return ResponseHelper::responseData(
                Config::get('constants.TRIP_STATUS_UPDATED'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                null
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.TRIP_INITIATED_FAIL'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }

    /**
     * Method: cancelRequest
     *
     * @param IForm $cancelRequestForm
     *
     * @return array
     */
    public function cancelRequest(IForm $cancelRequestForm)
    {
        if($cancelRequestForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $cancelRequestForm->errors()
            );
        }

        $findRequest = $this->findById($cancelRequestForm->order_id);
        if($findRequest){

            $findRequest->status = IOrderStaus::ORDER_CANCELLED;
            $findRequest->update();

            $addTrip = true;
            $currentDate = date('Y-m-d');
            $addOneDay = date('Y-m-d', strtotime($currentDate . ' +1 day'));
            if($addOneDay == $findRequest->collection_date){

                $currentTime = date('H:i:s');
                if($currentTime >= '21:00:00') {
                    $addTrip = false;
                }
            }
            if($addTrip){
                $authUser = App::make(UserService::class)->findById($findRequest->user_id);
                $returnUserTrip = App::make(UserSubscriptionService::class)->returnUserTrip($findRequest);
                if($authUser && $returnUserTrip){
                    $authUser->trips = $authUser->trips + 1;
                    $authUser->update();
                    $returnUserTrip->trips = $returnUserTrip->trips + 1;
                    $returnUserTrip->update();
                }
            }

            return ResponseHelper::responseData(
                Config::get('constants.CANCEL_REQUEST'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                null
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_ORDER_ID'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }
}
