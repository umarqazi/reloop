<?php

namespace App\Exceptions;

use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Method: unauthenticated
     *
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        $guard = $exception->guards()[0];
        $errorMessage = [
            "token" => [
                Config::get('constants.UN_AUTHORIZE_ERROR')
            ]
        ];
        switch ($guard) {
            case 'api':
                return ResponseHelper::jsonResponse(
                    Config::get('constants.UN_AUTHORIZE_ERROR'),
                    IResponseHelperInterface::FAIL_RESPONSE,
                    false,
                    $errorMessage
                );
                break;
        }
    }
}
