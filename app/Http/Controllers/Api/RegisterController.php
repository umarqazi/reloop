<?php

namespace App\Http\Controllers\Api;

use App\Forms\User\CreateForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\CityService;
use App\Services\DistrictService;
use App\Services\OrganizationService;
use App\Services\SectorService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class RegisterController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 20, 2020
 * @project   reloop
 */
class RegisterController extends Controller
{
    /**
     * Property: userService
     *
     * @var UserService
     */
    private $userService;

    /**
     * RegisterController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Method: register
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signUp(Request $request)
    {
        $regForm = new CreateForm();
        $regForm->loadFromArray( $request->all() );
        $regUser = $this->userService->store($regForm);

        return ResponseHelper::jsonResponse(
            $regUser['message'],
            $regUser['code'],
            $regUser['status'],
            $regUser['data']
        );
    }

    /**
     * Method: dependencies
     * Get dependencies list before signup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dependencies()
    {
        $cities = App::make(CityService::class)->getAll();
        $districts = App::make(DistrictService::class)->getAll();
        $sectors = App::make(SectorService::class)->getAll();
        $organizations   = App::make(OrganizationService::class)->getAll();
        $data = [
            'cities' => $cities,
            'districts' => $districts,
            'sectors' => $sectors,
            'organizations' => $organizations,
        ];
        return ResponseHelper::jsonResponse(
            Config::get('constants.DEPENDENCIES_LIST'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $data
        );
    }
}
