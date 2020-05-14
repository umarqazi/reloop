<?php


namespace App\Helpers;


use Illuminate\Support\Carbon;

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

    /**
     * @param bool $zero
     * @return int|null
     */
    public static function getActiveWeek($zero = true)
    {
        $index = null;
        $month = now()->format('m');
        if($month <= 4)
        {
            $index = 0;
        }

        if ($month > 4 && $month <= 8)
        {
            $index = 1;
        }

        if($month > 8 && $month <= 12)
        {
            $index = 2;
        }

        return $zero ? $index : ++ $index;
    }

    /**
     * @param $date
     * @return Carbon
     * @throws \Exception
     */
    public static function carbon($date)
    {
        return new Carbon($date);
    }
}
