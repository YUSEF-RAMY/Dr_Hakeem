<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Success response helper method.
     *
     * @param mixed $result Data payload or Resource
     * @param string $message User friendly message
     * @param int $code HTTP Status Code
     * @return JsonResponse
     */
    public function sendResponse(mixed $result, string $message = 'Success', int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];

        return response()->json($response, $code);
    }

    /**
     * Error response helper method.
     *
     * @param string $error Main error message
     * @param array $errorMessages Detailed error array or validation errors
     * @param int $code HTTP Status Code
     * @return JsonResponse
     */
    public function sendError(string $error, array $errorMessages = [], int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
