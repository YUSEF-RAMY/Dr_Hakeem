<?php

namespace App\Actions\Patient;

use App\Models\PatientProfile;

class UpdatePatientSettingsAction
{
    public function execute(PatientProfile $profile, array $data): PatientProfile
    {
        $updatePayload = [];

        if (isset($data['age'])) {
            $updatePayload['age'] = $data['age'];
        }
        if (isset($data['blood_group'])) {
            $updatePayload['blood_group'] = $data['blood_group'];
        }
        if (isset($data['skin_type'])) {
            $updatePayload['skin_type'] = $data['skin_type'];
        }
        if (isset($data['conditions'])) {
            $updatePayload['conditions'] = $data['conditions'];
        }
        if (isset($data['active_allergies'])) {
            $updatePayload['active_allergies'] = $data['active_allergies'];
        }
        if (isset($data['settings'])) {
            $currentSettings = $profile->settings ?? [];
            $updatePayload['settings'] = array_merge($currentSettings, $data['settings']);
        }

        $profile->update($updatePayload);

        return $profile->fresh();
    }
}
