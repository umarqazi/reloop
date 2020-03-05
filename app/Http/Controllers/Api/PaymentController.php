<?php

namespace App\Http\Controllers\Api;

use App\Forms\PaymentForm;
use App\Services\StripeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function checkout(Request $request)
    {
        $makePayment = $this->stripeService->makePayment($request->all());
    }
}
