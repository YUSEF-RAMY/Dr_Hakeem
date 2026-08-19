<?php

namespace App\Repositories\Eloquent;

use App\Models\Diagnosis;
use App\Repositories\Contracts\DiagnosisRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DiagnosisRepository implements DiagnosisRepositoryInterface
{
    public function create(array $data): Diagnosis
    {
        return Diagnosis::create($data);
    }

    public function findById(int $id): ?Diagnosis
    {
        return Diagnosis::with('user')->find($id);
    }

    public function getUserDiagnoses(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Diagnosis::where('user_id', $userId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['predicted_class'])) {
            $query->where('predicted_class', $filters['predicted_class']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getAllDiagnoses(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Diagnosis::with('user');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['predicted_class'])) {
            $query->where('predicted_class', $filters['predicted_class']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function update(Diagnosis $diagnosis, array $data): bool
    {
        return $diagnosis->update($data);
    }

    public function delete(Diagnosis $diagnosis): bool
    {
        return $diagnosis->delete();
    }
}
