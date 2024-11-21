<?php

namespace App\Http\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;

class Helper
{

    public static function sendError($message, $errors = [])
    {
        $response = [
            'success'   => false,
            'message' => $message,
            'data' => $errors
        ];

        // if (!empty($errors)) {
        //     $response['data'] = $errors;
        // }
        throw new HttpResponseException(response()->json($response));
    }
}
