<?php

namespace App\Helper\Api;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    /** 
     * Function : Common function to return api request response
     * @param string $status
     * @param string $message
     * @param string $data
     * @param int $statusCode
     * @return response 
     */
    public static function success($message, $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
    public static function error($message,  $data = null, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }
}
