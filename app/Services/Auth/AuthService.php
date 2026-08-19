<?php

namespace App\Services\Auth;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Models\User;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct(
        protected RegisterUserAction $registerUserAction,
        protected LoginUserAction $loginUserAction
    ) {}

    public function register(array $data): array
    {
        return $this->registerUserAction->execute($data);
    }

    public function login(array $credentials): array
    {
        return $this->loginUserAction->execute($credentials);
    }

    public function logout(User $user, bool $allDevices = false): bool
    {
        if ($allDevices) {
            $user->tokens()->delete();
        } else {
            $user->currentAccessToken()?->delete();
        }

        return true;
    }

    public function getProfile(User $user): User
    {
        return $user->load('roles', 'permissions');
    }
}
