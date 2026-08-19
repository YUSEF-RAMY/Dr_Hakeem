<?php

namespace App\Repositories\Contracts;

use App\Models\Diagnosis;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DiagnosisRepositoryInterface
{
    public function create(array $data): Diagnosis;

    public function findById(int $id): ?Diagnosis;

    public function getUserDiagnoses(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function getAllDiagnoses(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function update(Diagnosis $diagnosis, array $data): bool;

    public function delete(Diagnosis $diagnosis): bool;
}
