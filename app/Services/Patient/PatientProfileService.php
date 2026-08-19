<?php

namespace App\Services\Patient;

use App\Actions\Patient\UpdatePatientSettingsAction;
use App\Models\PatientProfile;
use App\Models\User;
use App\Repositories\Contracts\PatientProfileRepositoryInterface;
use Illuminate\Support\Str;

class PatientProfileService
{
    public function __construct(
        protected PatientProfileRepositoryInterface $patientProfileRepository,
        protected UpdatePatientSettingsAction $updateSettingsAction
    ) {}

    public function getProfile(User $user): PatientProfile
    {
        $profile = $this->patientProfileRepository->findByUserId($user->id);

        if (!$profile) {
            $patientCode = 'PAT-' . strtoupper(Str::random(6));
            $profile = $this->patientProfileRepository->create([
                'user_id'      => $user->id,
                'patient_code' => $patientCode,
                'settings'     => [
                    'notifications_enabled' => true,
                    'dark_mode'             => false,
                    'language'              => 'ar',
                ],
            ]);
        }

        return $profile->load('user');
    }

    public function updateSettings(User $user, array $data): PatientProfile
    {
        $profile = $this->getProfile($user);

        return $this->updateSettingsAction->execute($profile, $data);
    }
}
