<?php


namespace App\Services;


use App\District;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

class DistrictService extends BaseService
{

    /**
     * Property: model
     *
     * @var District
     */
    private $model;

    public function __construct(District $model)
    {
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
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Method: orderAcceptanceDays
     *
     * @param IForm $form
     *
     * @return array
     */
    public function orderAcceptanceDays(IForm $form)
    {
        if($form->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $form->errors()
            );
        }
        $orderAcceptanceDays = $this->model->where('id', $form->district_id)->first();
        if ($orderAcceptanceDays){

            $data = [
                'id' => $orderAcceptanceDays->id,
                'city_id' => $orderAcceptanceDays->city_id,
                'name' => $orderAcceptanceDays->name,
                'status' => $orderAcceptanceDays->status,
                'order_acceptance_days' => explode(',', $orderAcceptanceDays->order_acceptance_days),
            ];
            return ResponseHelper::responseData(
                Config::get('constants.ORDER_ACCEPTANCE_DAYS'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                $data
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }
}
