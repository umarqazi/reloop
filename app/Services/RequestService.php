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
        // TODO: Implement findById() method.
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

        if(!empty($collectionRequestForm->card_number)){

            $stripeService = new StripeService();
            $makePayment = $stripeService->buyPlan($collectionRequestForm);
            if(array_key_exists('stripe_error', $makePayment)){

                return ResponseHelper::responseData(
                    Config::get('constants.ORDER_FAIL'),
                    IResponseHelperInterface::FAIL_RESPONSE,
                    false,
                    $makePayment
                );
            }
        }

        $material_categories = App::make(MaterialCategoryService::class)->findMaterialCategoryById($collectionRequestForm->material_categories);
        $saveData = [
            'material_category_details' => $material_categories,
            'collection_form_data' => $collectionRequestForm,
            'user_id' => auth()->id(),
            'request_number' => $this->request_number
        ];
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
                'district', 'street', 'created_at')
            ->where('user_id', auth()->id())->get();
    }
}
