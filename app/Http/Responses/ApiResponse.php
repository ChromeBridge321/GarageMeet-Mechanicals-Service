<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponse
{
    public static function success(string $message, $data = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        $response = ['message' => $message];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    public static function error(string $message, string $error = '', int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $response = ['message' => $message];

        if (!empty($error)) {
            $response['error'] = $error;
        }

        return response()->json($response, $statusCode);
    }

    public static function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json(['message' => $message], Response::HTTP_NOT_FOUND);
    }

    public static function created(string $message, $data = null): JsonResponse
    {
        return self::success($message, $data, Response::HTTP_CREATED);
    }
}
