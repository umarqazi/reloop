<?php


namespace App\Helpers;


/**
 * Class ResponseHelper
 *
 * @package   App\Helpers
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 20, 2020
 * @project   reloop
 */
class ResponseHelper implements IResponseHelperInterface
{
    public static function jsonResponse($msg, $code = IResponseHelperInterface::SUCCESS_RESPONSE, $status=true, $data = null)
    {
        return response()->json(['message' => $msg, 'code' => $code, 'status' => $status, 'data' => $data], $code);
    }

    public static function responseData($message, $code, $status, $data)
    {
        $responseData = [
            'message' => $message,
            'code' => $code,
            'status' => $status,
            'data' => $data
        ];
        return $responseData;
    }
}
