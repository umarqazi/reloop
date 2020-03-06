<?php

namespace App\Http\Controllers\Api;

use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Jobs\SaveOrderDetailsJob;
use App\Services\StripeService;
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

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function checkout(Request $request)
    {
        $makePayment = $this->stripeService->checkout($request->all());

        if(!empty($makePayment)){

            SaveOrderDetailsJob::dispatch($makePayment);
            return ResponseHelper::jsonResponse(
                Config::get('constants.ORDER_SUCCESSFUL'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                $makePayment
            );
        }
    }
}
