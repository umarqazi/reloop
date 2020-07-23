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
     * Method: create
     *
     * @param $data
     *
     * @return UserSubscription
     */
    public function create($data)
    {
        $startTime = null;
        $endTime = null;
        $stripeSubId = null;
        $subscriptionType = $data['product_details']->category_type;
        $status = IUserSubscriptionStatus::ACTIVE;
        $model = $this->model;
        $coupon = App::make(CouponService::class)->findById($data['request_data']->coupon_id);
        if($data['product_details']->category->service_type == ISubscriptionType::MONTHLY){

            $startTime = date("Y-m-d h:i:s",$data['stripe_response']['current_period_start']);
            $endTime = date("Y-m-d h:i:s",$data['stripe_response']['current_period_end']);
            $stripeSubId = $data['stripe_response']['id'];
            $subscriptionType = ISubscriptionSubType::NORMAL;

            $userSubscriptionStatus = $model->where([
                'user_id' => $data['user_id'],
                'status' => IUserSubscriptionStatus::ACTIVE
            ])->whereNotNull('stripe_subscription_id')->first();
            if(!empty($userSubscriptionStatus)){

                $status = IUserSubscriptionStatus::PENDING;
            }
        }

        $model->user_id = $data['user_id'];
        $model->subscription_id = $data['product_details']->id;
        $model->stripe_subscription_id = $stripeSubId;
        $model->subscription_number = $data['order_number'];
        $model->subscription_type = $subscriptionType;
        $model->coupon = $coupon->code ?? null;
        $model->total = $data['request_data']->total;
        $model->status = $status;
        $model->start_date = $startTime;
        $model->end_date = $endTime;
        $model->trips = $data['product_details']->request_allowed;
        $model->save();

        return $model;
    }

    /**
     * Method: findByUserId
     *
     * @param $userId
     *
     * @return mixed
     */
    public function findByUserId($userId)
    {
        return $this->model->where(['user_id' => $userId, 'status' => IUserSubscriptionStatus::ACTIVE])->with('subscription.category')->get();
    }

    /**
     * Method: userSubscriptions
     *
     * @param $userId
     *
     * @return mixed
     */
    public function userSubscriptions($userId)
    {
        return $this->model->where(['user_id' => $userId])->orderBy('status', 'ASC')->with('subscription')->get();
    }

    /**
     * Method: userSubscriptionsBilling
     *
     * @param $id
     *
     * @return UserSubscription|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function userSubscriptionsBilling($id)
    {
        $userSubscriptionsBilling = $this->model->with([
            'subscription' => function ($query){
                return $query->select('id', 'name', 'request_allowed', 'price');
            }
        ])
            ->where('id', $id) ->first();

        return $userSubscriptionsBilling;
    }

    /**
     * Method: updateTrips
     *
     * @param $data
     *
     * @return void
     */
    public function updateTrips($data)
    {
        $updateTrips = $this->checkUserTrips($data);
        if(!empty($updateTrips)){

            $updatedTrips = $updateTrips->trips - 1;
            $updateTrips->trips = $updatedTrips;
            $updateTrips->status = ($updatedTrips == 0) ? IUserSubscriptionStatus::COMPLETED : IUserSubscriptionStatus::ACTIVE;
            $updateTrips->update();

            return true;
        }
    }

    /**
     * Method: checkUserTrips
     *
     * @param $data
     *
     * @return mixed
     */
    public function checkUserTrips($data)
    {
        return $this->model->where([
            'user_id' => $data['user_id'],
            'subscription_type' => $data['collection_form_data']->collection_type,
            'status' => IUserSubscriptionStatus::ACTIVE
        ])->first();
    }

    /**
     * Method: returnUserTrip
     *
     * @param $data
     *
     * @return mixed
     */
    public function returnUserTrip($data)
    {
        return $this->model->where([
            'user_id' => $data->user_id,
            'subscription_type' => $data->collection_type,
            'status' => IUserSubscriptionStatus::ACTIVE
            ])->orWhere(function($query) {
                $query->where('status', IUserSubscriptionStatus::COMPLETED);
            })->first();
    }
}
