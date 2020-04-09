<?php

namespace App\Http\Controllers\Api;
use App\Forms\Collection\RecordWeightForm;
use App\Forms\Collection\TripInitiatedForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\IOrderType;
use App\Services\OrderService;
use App\Services\RequestCollectionService;
use App\Services\RequestService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Class DriverController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 08, 2020
 * @project   reloop
 */
class DriverController extends Controller
{
    /**
     * Property: userService
     *
     * @var UserService
     */
    private $userService;
    /**
     * Property: requestCollectionService
     *
     * @var RequestCollectionService
     */
    private $requestCollectionService;
    /**
     * Property: requestService
     *
     * @var RequestService
     */
    private $requestService;
    /**
     * Property: orderService
     *
     * @var OrderService
     */
    private $orderService;

    /**
     * DriverController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService, OrderService $orderService,
                                RequestService $requestService,
                                RequestCollectionService $requestCollectionService
    )
    {
        $this->userService = $userService;
        $this->requestCollectionService = $requestCollectionService;
        $this->requestService = $requestService;
        $this->orderService = $orderService;
    }

    /**
     * Method: driverAssignedTrips
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function driverAssignedTrips()
    {
        $driverAssignedTrips = $this->userService->driverAssignedTrips();

        return ResponseHelper::jsonResponse(
            $driverAssignedTrips['message'],
            $driverAssignedTrips['code'],
            $driverAssignedTrips['status'],
            $driverAssignedTrips['data']
        );
    }

    /**
     * Method: tripInitiated
     *
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tripInitiated(Request $request)
    {
        $tripInitiatedForm = new TripInitiatedForm();
        $tripInitiatedForm->loadFromArray($request->all());

        if($tripInitiatedForm->fails()){

            return ResponseHelper::jsonResponse(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $tripInitiatedForm->errors()
            );
        }

        if($tripInitiatedForm->order_type == IOrderType::COLLECTION_REQUEST){

            $tripInitiated = $this->requestService->updateRequestStatus($tripInitiatedForm->order_id);
        } elseif($tripInitiatedForm->order_type == IOrderType::DELIEVERY_ORDER) {

            $tripInitiated = $this->orderService->updateOrderStatus($tripInitiatedForm->order_id);
        }

        return ResponseHelper::jsonResponse(
            $tripInitiated['message'],
            $tripInitiated['code'],
            $tripInitiated['status'],
            $tripInitiated['data']
        );
    }

    /**
     * Method: recordWeight
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordWeight(Request $request)
    {
        $recordWeightForm = new RecordWeightForm();
        $recordWeightForm->loadFromArray($request->all());

        $recordWeight = $this->requestCollectionService->recordWeight($recordWeightForm);

        return ResponseHelper::jsonResponse(
            $recordWeight['message'],
            $recordWeight['code'],
            $recordWeight['status'],
            $recordWeight['data']
        );
    }
}
