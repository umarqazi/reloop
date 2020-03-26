<?php


namespace App\Services;


use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
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
     * RequestService constructor.
     * @param Request $model
     */
    public function __construct(Request $model)
    {
        $this->request_number = 'RE'.strtotime(now());
        parent::__construct();
        $this->model = $model;
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
     * @param $data
     *
     * @return array
     */
    public function collectionRequest($data)
    {
        if(!empty($data->card_number)){

            $stripeService = new StripeService();
            $makePayment = $stripeService->buyPlan($data);
            if(array_key_exists('stripe_error', $makePayment)){

                $responseData = [
                    'message' => Config::get('constants.ORDER_FAIL'),
                    'code' => IResponseHelperInterface::FAIL_RESPONSE,
                    'status' => false,
                    'data' => $makePayment
                ];
                return $responseData;
            }
        }

        $material_categories = App::make(MaterialCategoryService::class)->findMaterialCategoryById($data->material_categories);
        $saveData = [
            'material_categories' => $material_categories,
            'collection_form_data' => $data,
            'user_id' => auth()->id(),
            'request_number' => $this->request_number
        ];
        SaveCollectionRequestDetailsJob::dispatch($saveData);

        $responseData = [
            'message' => Config::get('constants.COLLECTION_SUCCESSFUL'),
            'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
            'status' => true,
            'data' => [
                'collection_request' => [
                    $this->request_number
                ],
            ],
        ];
        return $responseData;
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
        $saveRequestDetails = $this->create($data);
        $saveRequestCollectionDetails = App::make(RequestCollectionService::class)->create($data, $saveRequestDetails->id);
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
            'first_name' => $data['collection_form_data']->first_name,
            'last_name' => $data['collection_form_data']->last_name,
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
}
