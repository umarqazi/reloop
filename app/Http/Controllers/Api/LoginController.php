<?php

namespace App\Http\Controllers\Api;

use App\Forms\User\LoginForm;
use App\Forms\User\PasswordForgotForm;
use App\Forms\User\PasswordResetForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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

    public function getPasswordResetToken(Request $request)
    {
        $resetForm = new PasswordResetForm();
        $resetForm->loadFromArray($request->all());
        $userEmail = $this->userService->getPasswordForgotToken($resetForm);

        return ResponseHelper::jsonResponse(
            $userEmail['message'],
            $userEmail['code'],
            $userEmail['status'],
            $userEmail['data']
        );
    }

    public function getPasswordForgotToken(Request $request)
    {
        $forgotForm = new PasswordForgotForm();
        $forgotForm->loadFromArray($request->all());
        $userEmail = $this->userService->getPasswordForgotToken($forgotForm);

        return ResponseHelper::jsonResponse(
            $userEmail['message'],
            $userEmail['code'],
            $userEmail['status'],
            $userEmail['data']
        );
    }
}
