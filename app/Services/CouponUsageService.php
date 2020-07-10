<?php


namespace App\Services;


use App\CouponUsage;
use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

/**
 * Class CouponUsageService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Jul 10, 2020
 * @project   reloop
 */
class CouponUsageService extends BaseService
{

    /**
     * Property: model
     *
     * @var CouponUsage
     */
    private $model;

    public function __construct(CouponUsage $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function store(IForm $form)
    {
        // TODO: Implement store() method.
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: checkCouponUsage
     *
     * @param $couponId
     * @param $userId
     *
     * @return mixed
     */
    public function checkCouponUsage($couponId, $userId)
    {
        return $this->model->where(['coupon_id' => $couponId, 'user_id' => $userId])->first();
    }

    /**
     * Method: couponUsage
     *
     * @param $couponId
     * @param $userId
     *
     * @return void
     */
    public function couponUsage($couponId, $userId)
    {
        $checkCoupon = $this->checkCouponUsage($couponId, $userId);
        if($checkCoupon){
            $checkCoupon->no_of_usage = $checkCoupon->no_of_usage + 1;
            $checkCoupon->update();
        } else {
            $this->model->create([
                'coupon_id' => $couponId,
                'user_id' => $userId,
                'no_of_usage' => 1,
            ]);
        }
    }
}
