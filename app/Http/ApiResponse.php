<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Build a successful JSON response.
     *
     * @param mixed $data
     */
    public static function success(mixed $data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    /**
     * Build a failed JSON response.
     *
     * @param array<string, mixed> $errors
     */
    public static function error(string $message = 'Error', array $errors = [], int $code = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
