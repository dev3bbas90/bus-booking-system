<?php

namespace  App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;

/**
 * @OA\Info(title="Bus Booking System", version="0.1")
*/
class ApiBaseController extends Controller
{

    public function success($data = null, $message = 'success')
    {
        $response = [
            'message'       => $message,
            'data'          => $data,
        ];
        return response()->json($response);
    }

    public function error($errors = null, $message = 'error' , $code = 400)
    {
        $response = [
            'message'       => $message,
            'errors'          => $errors,
        ];
        return response()->json($response , $code);
    }
}
