<?php

namespace App\Http\Controllers;

use App\Services\PayfortService;
use App\Services\ProductService;
use Illuminate\Http\Request;

/**
 * Class PayfortController
 *
 * @package   App\Http\Controllers
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Aug 08, 2020
 * @project   reloop
 */
class PayfortController extends Controller
{
    /**
     * Property: payfortService
     *
     * @var PayfortService
     */
    private $payfortService;

    /**
     * PayfortController constructor.
     * @param PayfortService $payfortService
     */
    public function __construct(PayfortService $payfortService)
    {
        $this->payfortService     = $payfortService;
    }

    /**
     * Method: paymentPage
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentPage()
    {
        return view('payment-page');
    }

    /**
     * Method: merchantConfirmationPage
     *
     * @param Request $request
     *
     * @return void
     */
    public function merchantConfirmationPage(Request $request)
    {
        $this->payfortService->merchantConfirmationPage($request->all());
    }

    /**
     * Method: createToken
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createToken(Request $request)
    {
        return $this->payfortService->createToken($request->all());
    }

    /**
     * Method: tokenResponse
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tokenResponse()
    {
        return $this->payfortService->tokenResponse();
    }

    /**
     * Method: paymentResponse
     *
     * @return array
     */
    public function paymentResponse()
    {
        return $this->payfortService->paymentResponse();
    }

    /**
     * Method: recurring
     *
     * @param $amount
     * @param $email
     * @param $tokenName
     * @param $userSubscriptionId
     *
     * @return void
     */
    public function recurring($amount, $email, $tokenName, $userSubscriptionId)
    {
        $this->payfortService->recurring($amount, $email, $tokenName, $userSubscriptionId);
    }

}
