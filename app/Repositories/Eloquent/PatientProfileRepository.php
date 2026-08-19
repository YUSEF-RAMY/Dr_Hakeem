<?php

namespace App\Repositories\Eloquent;

use App\Models\PatientProfile;
use App\Repositories\Contracts\PatientProfileRepositoryInterface;

class PatientProfileRepository implements PatientProfileRepositoryInterface
{
    public function create(array $data): PatientProfile
    {
        return PatientProfile::create($data);
    }

    public function findByUserId(int $userId): ?PatientProfile
    {
        return PatientProfile::where('user_id', $userId)->first();
    }

    public function update(PatientProfile $profile, array $data): bool
    {
        return $profile->update($data);
    }
}
