<?php

namespace App\Services\Diagnosis;

use App\Actions\Diagnosis\DeleteDiagnosisAction;
use App\Actions\Diagnosis\ProcessSkinScanAction;
use App\Models\Diagnosis;
use App\Models\User;
use App\Repositories\Contracts\DiagnosisRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class DiagnosisService
{
    public function __construct(
        protected ProcessSkinScanAction $processSkinScanAction,
        protected DeleteDiagnosisAction $deleteDiagnosisAction,
        protected DiagnosisRepositoryInterface $diagnosisRepository
    ) {}

    public function processScan(User $user, UploadedFile $image, bool $tta = true): Diagnosis
    {
        return $this->processSkinScanAction->execute($user, $image, $tta);
    }

    public function getUserDiagnoses(User $user, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        if ($user->hasRole('admin') || $user->hasRole('doctor')) {
            return $this->diagnosisRepository->getAllDiagnoses($filters, $perPage);
        }

        return $this->diagnosisRepository->getUserDiagnoses($user->id, $filters, $perPage);
    }

    public function findById(int $id): ?Diagnosis
    {
        return $this->diagnosisRepository->findById($id);
    }

    public function deleteDiagnosis(Diagnosis $diagnosis): bool
    {
        return $this->deleteDiagnosisAction->execute($diagnosis);
    }
}
