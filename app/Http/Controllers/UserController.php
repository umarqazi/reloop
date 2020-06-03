<?php

namespace App\Http\Controllers;

use App\Forms\Checkout\RedeemPointForm;
use App\Forms\Organization\OrganizationVerificationForm;
use App\Forms\User\DefaultAddressForm;
use App\Forms\User\DeleteAddressForm;
use App\Forms\User\UpdateAddressForm;
use App\Forms\User\UpdateProfileForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Admin\ChartController;
use App\Services\Admin\EnvironmentalStatsDescriptionService;
use App\Services\DashboardService;
use App\Services\EnvironmentalStatService;
use App\Services\IUserType;
use App\Services\OrganizationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class UserController
 *
 * @package   App\Http\Controllers
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 25, 2020
 * @project   reloop
 */
class UserController extends Controller
{
    private $userService;
    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Method: dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboard()
    {
        $userDashboard = App::make(DashboardService::class)->userDashboard(auth()->id());

        return ResponseHelper::jsonResponse(
            $userDashboard['message'],
            $userDashboard['code'],
            $userDashboard['status'],
            $userDashboard['data']
        );
    }

    /**
     * Method: barChart
     * // User charts data
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function barChart(Request $request)
    {
        if(auth()->user()->user_type == IUserType::DRIVER){

            $userId['users']['driverId'] = auth()->id();
        } else {

            $userId['users']['userId'] = auth()->id();
        }
        $request->merge($userId);
        $userReports = App::make(ChartController::class)->barChart($request);
        $environmentalStats = App::make(EnvironmentalStatService::class)->userEnvironmentalStats(auth()->id());
        $environmentalStatsDescription = App::make(EnvironmentalStatsDescriptionService::class)->all();
        $userService = $this->userService->findById(auth()->id());
        $data = [
            'userReports' => $userReports,
            'environmentalStats' => $environmentalStats,
            'rewardPoints' => ($userService->reward_points) ? $userService->reward_points : 0,
            'environmentalStatsDescription' => $environmentalStatsDescription
        ];

        return ResponseHelper::jsonResponse(
            Config::get('constants.USER_CHARTS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $data
        );
    }

    /**
     * Method: accountVerification
     *
     * @param $id
     * @param $token
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function accountVerification($id, $token)
    {
        $activateAccount = $this->userService->activateAccount($id, $token);
        if($activateAccount){
            return redirect('thankyou');
        }
        return redirect('token-expired');
    }

    /**
     * Method: userProfile
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        $userProfile = $this->userService->userProfile();

        return ResponseHelper::jsonResponse(
            $userProfile['message'],
            $userProfile['code'],
            $userProfile['status'],
            $userProfile['data']
        );
    }

    /**
     * Method: updateAddress
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAddress(Request $request)
    {
        $updateAddressForm = new UpdateAddressForm();
        $updateAddressForm->loadFromArray($request->all());
        $updateAddress = $this->userService->updateAddress($updateAddressForm);

        return ResponseHelper::jsonResponse(
            $updateAddress['message'],
            $updateAddress['code'],
            $updateAddress['status'],
            $updateAddress['data']
        );
    }

    /**
     * Method: updateUserProfile
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserProfile(Request $request)
    {
        $updateProfileForm = new UpdateProfileForm();
        $updateProfileForm->loadFromArray($request->all());
        $updateProfile = $this->userService->updateUserProfile($updateProfileForm, $request);

        return ResponseHelper::jsonResponse(
            $updateProfile['message'],
            $updateProfile['code'],
            $updateProfile['status'],
            $updateProfile['data']
        );
    }

    /**
     * Method: deleteAddress
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAddress(Request $request)
    {
        $deleteAddressForm = new DeleteAddressForm();
        $deleteAddressForm->loadFromArray($request->all());
        $deleteAddress = $this->userService->deleteAddress($deleteAddressForm);

        return ResponseHelper::jsonResponse(
            $deleteAddress['message'],
            $deleteAddress['code'],
            $deleteAddress['status'],
            $deleteAddress['data']
        );
    }

    /**
     * Method: defaultAddress
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function defaultAddress(Request $request)
    {
        $defaultAddressForm = new DefaultAddressForm();
        $defaultAddressForm->loadFromArray($request->all());
        $defaultAddress = $this->userService->defaultAddress($defaultAddressForm);

        return ResponseHelper::jsonResponse(
            $defaultAddress['message'],
            $defaultAddress['code'],
            $defaultAddress['status'],
            $defaultAddress['data']
        );
    }

    /**
     * Method: getUserPlans
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPlans()
    {
        $userProfile = $this->userService->getUserPlans();

        return ResponseHelper::jsonResponse(
            $userProfile['message'],
            $userProfile['code'],
            $userProfile['status'],
            $userProfile['data']
        );
    }

    /**
     * Method: userSubscriptions
     * user subscriptions list
     * @return \Illuminate\Http\JsonResponse
     */
    public function userSubscriptions()
    {
        $userSubscriptions = $this->userService->userSubscriptions();

        return ResponseHelper::jsonResponse(
            $userSubscriptions['message'],
            $userSubscriptions['code'],
            $userSubscriptions['status'],
            $userSubscriptions['data']
        );
    }

    /**
     * Method: userBillings
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userBillings()
    {
        $userBilling = $this->userService->userBillings();

        return ResponseHelper::jsonResponse(
            $userBilling['message'],
            $userBilling['code'],
            $userBilling['status'],
            $userBilling['data']
        );
    }

    /**
     * Method: redeemPoints
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function redeemPoints(Request $request)
    {
        $redeemPointForm = new RedeemPointForm();
        $redeemPointForm->loadFromArray($request->all());
        $redeemPoints = $this->userService->redeemPoints($redeemPointForm);

        return ResponseHelper::jsonResponse(
            $redeemPoints['message'],
            $redeemPoints['code'],
            $redeemPoints['status'],
            $redeemPoints['data']
        );
    }

    /**
     * Method: currencyConversion
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currencyConversion()
    {
        $currencyConversion = $this->userService->currencyConversion();

        return ResponseHelper::jsonResponse(
            $currencyConversion['message'],
            $currencyConversion['code'],
            $currencyConversion['status'],
            $currencyConversion['data']
        );
    }

    /**
     * Method: organizationVerification
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function organizationVerification(Request $request)
    {
        $organizationVerificationForm = new OrganizationVerificationForm();
        $organizationVerificationForm->loadFromArray($request->all());
        $organization = App::make(OrganizationService::class)->organizationVerification($organizationVerificationForm);

        return ResponseHelper::jsonResponse(
            $organization['message'],
            $organization['code'],
            $organization['status'],
            $organization['data']
        );
    }
}
