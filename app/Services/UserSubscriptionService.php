<?php


namespace App\Services;


use App\Forms\IForm;
use App\UserSubscription;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

/**
 * Class UserSubscriptionService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class UserSubscriptionService extends BaseService
{

    /**
     * Property: model
     *
     * @var UserSubscription
     */
    private $model;

    public function __construct(UserSubscription $model)
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
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function create($data)
    {
        $startTime = null;
        $endTime = null;
        $stripeSubId = null;
        if($data['product_details']->category_id == ISubscriptionType::MONTHLY){

            $startTime = date("Y-m-d h:i:s",$data['stripe_response']['current_period_start']);
            $endTime = date("Y-m-d h:i:s",$data['stripe_response']['current_period_end']);
            $stripeSubId = $data['stripe_response']['id'];
        }

        $model = $this->model;
        $model->user_id = $data['user_id'];
        $model->subscription_id = $data['product_details']->id;
        $model->stripe_subscription_id = $stripeSubId;
        $model->subscription_number = $data['order_number'];
        $model->start_date = $startTime;
        $model->end_date = $endTime;
        $model->trips = $data['product_details']->request_allowed;
        $model->save();

        return $model;
    }
}
