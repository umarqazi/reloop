<?php

namespace App\Http\Controllers\Api;

use App\Forms\Checkout\CouponForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\CouponService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class CouponController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 16, 2020
 * @project   reloop
 */
class CouponController extends Controller
{
    /**
     * Method: couponVerification
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function couponVerification(Request $request)
    {
        $couponForm = new CouponForm();
        $couponForm->loadFromArray($request->all());
        $couponVerification = App::make(CouponService::class)->couponVerification($couponForm->coupon);
        if (!empty($couponVerification))
        {
            return ResponseHelper::jsonResponse(
                Config::get('constants.COUPON_VERIFICATION'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                $couponVerification
            );
        }
        $errorMessage = [
            "invalid_coupon" => [
                Config::get('constants.COUPON_FAIL')
            ]
        ];

        return ResponseHelper::jsonResponse(
            Config::get('constants.COUPON_FAIL'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            $errorMessage
        );
    }
}
