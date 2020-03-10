<?php

namespace App\Http\Controllers\Api;

use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Jobs\SaveOrderDetailsJob;
use App\Jobs\SaveSubscriptionDetailsJob;
use App\Services\ProductService;
use App\Services\StripeService;
use Carbon\Carbon;
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
     * Property: stripeService
     *
     * @var StripeService
     */
    private $stripeService;
    /**
     * Property: productService
     *
     * @var ProductService
     */
    private $productService;
    /**
     * Property: order_number
     *
     * @var string
     */
    private $order_number;

    public function __construct(StripeService $stripeService, ProductService $productService)
    {
        $this->stripeService = $stripeService;
        $this->productService = $productService;
        $this->order_number = 'RE'.strtotime(now());
    }

    public function buyPlan(Request $request)
    {
        $requestData = $request->all();
        $userId = auth()->id();
        $planDetails = $this->productService->findSubscriptionById($requestData['subscription_id']);

        if(!empty($planDetails)){

            $makePayment = $this->stripeService->buyPlan($requestData);

            if(!empty($makePayment)){

                $data = [
                    'stripe_response' => $makePayment,
                    'product_details' => $planDetails,
                    'user_id'         => $userId,
                    'order_number'    => $this->order_number
                ];
                $reponseData = [
                    'buy_plan' => [
                        'Your subscription number is '.$this->order_number
                    ]
                ];

                SaveSubscriptionDetailsJob::dispatch($data);
                return ResponseHelper::jsonResponse(
                    Config::get('constants.ORDER_SUCCESSFUL'),
                    IResponseHelperInterface::SUCCESS_RESPONSE,
                    true,
                    $reponseData
                );
            }
        }
        return ResponseHelper::jsonResponse(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false
        );
    }
}
