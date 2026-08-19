<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Repositories\Contracts\PatientProfileRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUserAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected PatientProfileRepositoryInterface $patientProfileRepository
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

        // Auto-generate PatientProfile with unique patient_code
        $patientCode = 'PAT-' . strtoupper(Str::random(6));
        $this->patientProfileRepository->create([
            'user_id'      => $user->id,
            'patient_code' => $patientCode,
            'settings'     => [
                'notifications_enabled' => true,
                'dark_mode'             => false,
                'language'              => 'ar',
            ],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'  => $user->load('roles', 'patientProfile'),
            'token' => $token,
        ];
    }
}
