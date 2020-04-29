<?php


namespace App\Services;


use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Jobs\SaveCollectionRequestDetailsJob;
use App\Request;
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
     * RequestService constructor.
     * @param Request $model
     */
    public function __construct(Request $model, UserSubscriptionService $userSubscriptionService)
    {
        $this->request_number = 'RE'.strtotime(now());
        parent::__construct();
        $this->model = $model;
        $this->userSubscriptionService = $userSubscriptionService;
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
            $saveData = [
                'material_category_details' => $material_categories,
                'collection_form_data' => $collectionRequestForm,
                'user_id' => auth()->id(),
                'request_number' => $this->request_number
            ];
            $checkUserTrips = App::make(UserSubscriptionService::class)->checkUserTrips($saveData);
            if ($checkUserTrips) {
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
                            $this->request_number
                        ],
                    ]
                );
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
            'request_number'  => $this->request_number,
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
            'city' => $city->name,
            'district' => $district->name,
            'street' => $data['collection_form_data']->street,
            'question_1' => $data['collection_form_data']->questions[0]['ques'],
            'answer_1' => $data['collection_form_data']->questions[0]['ans'],
            'question_2' => $data['collection_form_data']->questions[1]['ques'],
            'answer_2' => $data['collection_form_data']->questions[1]['ans']
        ]);
        return $model->fresh();
    }

    public function userCollectionRequests()
    {
        return $this->model->with('requestCollection')
            ->select('id', 'request_number', 'collection_date', 'location', 'latitude', 'longitude', 'city',
                'district', 'street', 'created_at', 'status')
            ->where('user_id', auth()->id())->get();
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
            }
        ]);
        if(!empty($date)){

            return $assignedTrips->select('id', 'request_number', 'collection_date', 'location', 'latitude', 'longitude', 'city',
                'district', 'street', 'created_at', 'status', 'driver_trip_status', 'phone_number')
                ->where(['driver_id' => $driverId, 'collection_date' => $date])->get();
        }
        return $assignedTrips->select('id', 'request_number', 'collection_date', 'location', 'latitude', 'longitude', 'city',
            'district', 'street', 'created_at', 'status', 'driver_trip_status', 'phone_number')
            ->where('driver_id', $driverId)->get();
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
            } elseif ($statusType == IOrderStatusType::TRIP_COMPLETED){

                $findRequest->status = IOrderStaus::ORDER_COMPLETED;
                $findRequest->driver_trip_status = IDriverTripStatus::TRIP_COMPLETED;
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
}
