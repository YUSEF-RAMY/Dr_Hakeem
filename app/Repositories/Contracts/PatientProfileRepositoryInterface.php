<?php

namespace App\Repositories\Contracts;

use App\Models\PatientProfile;

interface PatientProfileRepositoryInterface
{
    public function create(array $data): PatientProfile;

    public function findByUserId(int $userId): ?PatientProfile;

    public function update(PatientProfile $profile, array $data): bool;
}
