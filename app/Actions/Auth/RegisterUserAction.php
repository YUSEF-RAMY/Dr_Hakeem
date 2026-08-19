<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function execute(array $data): array
    {
        $user = $this->userRepository->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $role = $data['role'] ?? 'patient';
        if (in_array($role, ['patient', 'doctor'])) {
            $user->assignRole($role);
        } else {
            $user->assignRole('patient');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user->load('roles'),
            'token' => $token,
        ];
    }
}
