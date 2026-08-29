<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Register new user account.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return $this->sendResponse([
            'user'  => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'User account created successfully', 201);
    }

    /**
     * Authenticate user & return token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return $this->sendResponse([
            'user'  => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'User logged in successfully');
    }

    /**
     * Revoke access token (Logout).
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->sendResponse(null, 'User logged out successfully');
    }

    /**
     * Get current user profile details.
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $this->authService->getProfile($request->user());

        return $this->sendResponse(new UserResource($user), 'User profile details retrieved successfully');
    }
}
