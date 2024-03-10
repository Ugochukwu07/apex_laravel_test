<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseHelper
{
    public static function dataResponse(array|JsonResource $data = [], string $message = "Success", int $status = 200, int $code = 200, bool $success = true): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'status' => $status
        ], $code);
    }

    public static function response(string $message = "Success", int $status = 200, bool $success = true, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'status' => $status
        ], $code);
    }

    public static function notLoggedInResponse(){
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access request, Please login.',
            'status' => 401
        ], 200);
    }

    public static function response404($elm, $message = 'Not Found'){
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => "$elm not found",
            'status' => 404
        ], 200);
    }

    public static function somethingWentWrong($message = 'Sorry, Unable to complete request, Something went wrong'){
        return response()->json([
            'success' => false,
            'message' => $message,
            'status' => 500
        ], 200);
    }
}
