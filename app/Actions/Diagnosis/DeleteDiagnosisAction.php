<?php

namespace App\Actions\Diagnosis;

use App\Models\Diagnosis;
use App\Repositories\Contracts\DiagnosisRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class DeleteDiagnosisAction
{
    public function __construct(
        protected DiagnosisRepositoryInterface $diagnosisRepository
    ) {}

    public function execute(Diagnosis $diagnosis): bool
    {
        // Remove image file from storage disk if exists
        if ($diagnosis->image_path && Storage::disk('public')->exists($diagnosis->image_path)) {
            Storage::disk('public')->delete($diagnosis->image_path);
        }

        return $this->diagnosisRepository->delete($diagnosis);
    }
}
