<?php

namespace App\Http\Controllers\Api;

use App\Forms\Checkout\BuyPlanForm;
use App\Forms\Checkout\BuyProductForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Class PaymentController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 03, 2020
 * @project   reloop
 */
class PaymentController extends Controller
{
    /**
     * Property: paymentService
     *
     * @var PaymentService
     */
    private $paymentService;

    /**
     * PaymentController constructor.
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Method: buyPlan
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyPlan(Request $request)
    {
        $buyPlanForm = new BuyPlanForm();
        $buyPlanForm->loadFromArray($request->all());

        $buyPlan = $this->paymentService->buyPlan($buyPlanForm);
        if(!empty($buyPlan)){

            return ResponseHelper::jsonResponse(
                $buyPlan['message'],
                $buyPlan['code'],
                $buyPlan['status'],
                $buyPlan['data']
            );
        }
        return ResponseHelper::jsonResponse(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }

    /**
     * Method: buyProduct
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buyProduct(Request $request)
    {
        $buyProductForm = new BuyProductForm();
        $buyProductForm->loadFromArray($request->all());

        $buyProduct = $this->paymentService->buyProduct($buyProductForm, $request->all());
        if(!empty($buyProduct)){

            return ResponseHelper::jsonResponse(
                $buyProduct['message'],
                $buyProduct['code'],
                $buyProduct['status'],
                $buyProduct['data']
            );
        }
        return ResponseHelper::jsonResponse(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }
}
