<?php

namespace App\Http\Controllers\Api;

use App\Forms\User\ChangePasswordForm;
use App\Forms\User\LoginForm;
use App\Forms\User\PasswordForgotForm;
use App\Helpers\ResponseHelper;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class LoginController
 *
 * @package   App\Http\Controllers\Api
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 25, 2020
 * @project   reloop
 */
class LoginController extends Controller
{
    private $userService;

    /**
     * LoginController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Method: login
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $loginForm = new LoginForm();
        $loginForm->loadFromArray($request->all());
        $authUser = $this->userService->authenticate($loginForm);

        return ResponseHelper::jsonResponse(
            $authUser['message'],
            $authUser['code'],
            $authUser['status'],
            $authUser['data']
        );
    }

    /**
     * Method: changePassword
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $changePasswordForm = new ChangePasswordForm();
        $changePasswordForm->loadFromArray($request->all());
        $changePassword = $this->userService->changePassword($changePasswordForm);

        return ResponseHelper::jsonResponse(
            $changePassword['message'],
            $changePassword['code'],
            $changePassword['status'],
            $changePassword['data']
        );
    }

    /**
     * Method: forgotPassword
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $forgotForm = new PasswordForgotForm();
        $forgotForm->loadFromArray($request->all());
        $forgotPassword = $this->userService->forgotPassword($forgotForm);

        return ResponseHelper::jsonResponse(
            $forgotPassword['message'],
            $forgotPassword['code'],
            $forgotPassword['status'],
            $forgotPassword['data']
        );
    }
}
