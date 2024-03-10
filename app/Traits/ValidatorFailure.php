<?php

namespace App\Traits;

trait ValidatorFailure
{
    public static function returnMessage($validator)
    {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'reason' => $validator->errors()->first(),
            'errors' => $validator->errors(),
            'status' => 403
        ], 200);
    }

    public static function noRecordMessage($elm, $message = 'Not Found'){
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
