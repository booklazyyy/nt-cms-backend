<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ResponseClass
{
    public static function rollback($e, $message = "Something went wrong! Process not completed")
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $code, $message = "Something went wrong! Process not completed")
    {
        Log::info($e);
        throw new HttpResponseException(response()->json(['success' => false, "message" => $e->getMessage()], $code));
    }

    public static function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (is_array($result)) {
            $response = array_merge($response, $result);
        } else {
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }

    public static function sendError($result, $message, $code = 400)
    {
        $response = [
            'success' => false
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }

        if (is_array($result)) {
            $response = array_merge($response, $result);
        } else {
            $response['data'] = $result;
        }

        return response()->json($response, $code);
    }
}
