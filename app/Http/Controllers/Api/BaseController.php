<?php

namespace App\Http\Controllers\Api;

use App\Http\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseController extends Controller
{
    /**
     * Success response helper method.
     *
     * @param mixed $result Data payload or Resource
     * @param string $message User friendly message
     * @param int $code HTTP Status Code
     */
    public function sendResponse(mixed $result, string $message = 'Success', int $code = 200): JsonResponse
    {
        return ApiResponse::success($result, $message, $code);
    }

    /**
     * Error response helper method.
     *
     * @param string $error Main error message
     * @param array $errorMessages Detailed error array or validation errors
     * @param int $code HTTP Status Code
     */
    public function sendError(string $error, array $errorMessages = [], int $code = 404): JsonResponse
    {
        return ApiResponse::error($error, $errorMessages, $code);
    }

    /**
     * Standard 404 not found response for a missing resource.
     */
    public function sendNotFound(string $resource = 'Resource'): JsonResponse
    {
        return ApiResponse::error($resource . ' not found', [], 404);
    }

    /**
     * Standard 401 unauthorised response.
     */
    public function sendUnauthorized(string $message = 'Unauthenticated.'): JsonResponse
    {
        return ApiResponse::error($message, [], 401);
    }

    /**
     * Standard 403 forbidden response.
     */
    public function sendForbidden(string $message = 'This action is unauthorized.'): JsonResponse
    {
        return ApiResponse::error($message, [], 403);
    }

    /**
     * Standard 500 internal server error response.
     */
    public function sendServerError(string $message = 'Something went wrong. Please try again later.'): JsonResponse
    {
        return ApiResponse::error($message, [], 500);
    }

    /**
     * Standard 503 service unavailable response (e.g. external AI model failure).
     */
    public function sendServiceUnavailable(string $message = 'The AI diagnosis service is currently unavailable. Please try again later.'): JsonResponse
    {
        return ApiResponse::error($message, [], 503);
    }

    /**
     * Extract validation errors and format them as a 422 response.
     */
    public function sendValidationError(ValidationException $e): JsonResponse
    {
        return ApiResponse::error('The given data was invalid.', $e->errors(), 422);
    }
}
