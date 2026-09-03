<?php

namespace App\Actions\Auth;

use App\Exceptions\InvalidCredentialsException;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(array $credentials): array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new InvalidCredentialsException('The provided credentials do not match our records.');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user->load('roles'),
            'token' => $token,
        ];
    }
}
