<?php

namespace App\Http\Controllers;

use App\Forms\User\UpdateAddressForm;
use App\Forms\User\UpdateProfileForm;
use App\Helpers\ResponseHelper;
use App\Services\UserService;
use Illuminate\Http\Request;

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
}
