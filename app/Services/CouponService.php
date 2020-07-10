<?php


namespace App\Services;
use App\Coupon;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class CouponService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 12, 2020
 * @project   reloop
 */
class CouponService extends BaseService
{

    /**
     * Property: model
     *
     * @var Coupon
     */
    private $model;

    public function __construct(Coupon $model)
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
     * Method: findByCouponCode
     *
     * @param $coupon
     *
     * @return mixed
     */
    public function findByCouponCode($coupon)
    {
        return $this->model->where('code', $coupon)->first();
    }

    /**
     * Method: couponVerification
     *
     * @param IForm $couponForm
     *
     * @return array
     */
    public function couponVerification(IForm $couponForm)
    {
        if ($couponForm->fails()) {

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $couponForm->errors()
            );
        }
        $findCoupon = $this->findByCouponCode($couponForm->coupon);
        if($findCoupon){

            $authUser = App::make(UserService::class)->findById(auth()->id());
            $couponUsage = App::make(CouponUsageService::class)->checkCouponUsage($findCoupon->id, $authUser->id);
            if(empty($couponUsage) || $couponUsage->no_of_usage < $findCoupon->max_usage_per_user){

                if($findCoupon->apply_for_user == IApplyForUser::APPLY_ON_SPECIFIC_USER){

                    if($findCoupon->list_user_id == $authUser->id){

                        return ResponseHelper::responseData(
                            Config::get('constants.COUPON_VERIFICATION'),
                            IResponseHelperInterface::SUCCESS_RESPONSE,
                            true,
                            [
                                "couponDetails" => $findCoupon,
                                "validForCategory" => $this->validateCategory($findCoupon, $couponForm),
                            ]
                        );
                    } else {
                        return ResponseHelper::responseData(
                            Config::get('constants.COUPON_FAIL'),
                            IResponseHelperInterface::FAIL_RESPONSE,
                            false,
                            [
                                "invalid_coupon" => [
                                    Config::get('constants.COUPON_FAIL')
                                ]
                            ]
                        );
                    }
                }elseif ($findCoupon->apply_for_user == IApplyForUser::APPLY_ON_USER_TYPE){

                    if($findCoupon->coupon_user_type == $authUser->user_type){
                        return ResponseHelper::responseData(
                            Config::get('constants.COUPON_VERIFICATION'),
                            IResponseHelperInterface::SUCCESS_RESPONSE,
                            true,
                            [
                                "couponDetails" => $findCoupon,
                                "validForCategory" => $this->validateCategory($findCoupon, $couponForm),
                            ]
                        );
                    } else {
                        return ResponseHelper::responseData(
                            Config::get('constants.COUPON_FAIL'),
                            IResponseHelperInterface::FAIL_RESPONSE,
                            false,
                            [
                                "invalid_coupon" => [
                                    Config::get('constants.COUPON_FAIL')
                                ]
                            ]
                        );
                    }
                }
            } else {
                return ResponseHelper::responseData(
                    Config::get('constants.COUPON_FAIL'),
                    IResponseHelperInterface::FAIL_RESPONSE,
                    false,
                    [
                        "invalid_coupon" => [
                            Config::get('constants.COUPON_FAIL')
                        ]
                    ]
                );
            }
        }
        return ResponseHelper::responseData(
            Config::get('constants.COUPON_FAIL'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            [
                "invalid_coupon" => [
                    Config::get('constants.COUPON_FAIL')
                ]
            ]
        );
    }

    /**
     * Method: validateCategory
     *
     * @param $findCoupon
     * @param $couponForm
     *
     * @return mixed
     */
    private function validateCategory($findCoupon, $couponForm){
        foreach ($couponForm->category as $category){

            if($findCoupon->apply_for_category == IApplyForCategory::APPLY_ON_CATEGORY_TYPE){
                if($category['type'] == $findCoupon->coupon_category_type){
                    $categoryId['type'][] = $category['type'];
                    continue;
                }
            } elseif($findCoupon->apply_for_category == IApplyForCategory::APPLY_ON_SPECIFIC_CATEGORY){
                if($category['id'] == $findCoupon->list_category_id){
                    $categoryId['id'][] = $category['id'];
                }
            }
        }
        return $categoryId;
    }
}
