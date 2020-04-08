<?php

namespace App\Http\Controllers\Api;
use App\Helpers\ResponseHelper;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * DriverController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
}
