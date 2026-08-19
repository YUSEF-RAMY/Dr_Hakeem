<?php

namespace App\Actions\Auth;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(array $credentials): array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['البيانات المدخلة غير صحيحة، يرجى التأكد من البريد الإلكتروني وكلمة المرور.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user->load('roles'),
            'token' => $token,
        ];
    }
}
