<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Services\DistrictService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

/**
 * Class OrderController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 31, 2020
 * @project   reloop
 */
class OrderController extends Controller
{
    /**
     * Property: orderService
     *
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Method: userOrders
     * //get users orders list
     * @return \Illuminate\Http\JsonResponse
     */
    public function userOrders()
    {
        $userOrders = $this->orderService->userOrders();

        return ResponseHelper::jsonResponse(
            $userOrders['message'],
            $userOrders['code'],
            $userOrders['status'],
            $userOrders['data']
        );
    }

    public function orderAcceptanceDays(Request $request)
    {
        $orderAcceptanceDays = App::make(DistrictService::class)->orderAcceptanceDays($request->all());

        return ResponseHelper::jsonResponse(
            $orderAcceptanceDays['message'],
            $orderAcceptanceDays['code'],
            $orderAcceptanceDays['status'],
            $orderAcceptanceDays['data']
        );
    }
}
