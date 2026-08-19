<?php

namespace App\Actions\Diagnosis;

use App\Enums\ScanStatus;
use App\Enums\SkinDiseaseClass;
use App\Models\Diagnosis;
use App\Models\User;
use App\Repositories\Contracts\DiagnosisRepositoryInterface;
use App\Services\AI\SkinScanService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessSkinScanAction
{
    public function __construct(
        protected SaveUploadedImageAction $saveImageAction,
        protected SkinScanService $skinScanService,
        protected DiagnosisRepositoryInterface $diagnosisRepository
    ) {}

    public function execute(User $user, UploadedFile $image, bool $tta = true): Diagnosis
    {
        // 1. Store image to disk
        $imagePath = $this->saveImageAction->execute($image);

        // 2. Create pending diagnosis record
        $diagnosis = $this->diagnosisRepository->create([
            'user_id'    => $user->id,
            'image_path' => $imagePath,
            'status'     => ScanStatus::PENDING->value,
            'tta_used'   => $tta,
        ]);

        try {
            // 3. Call External AI Service
            $aiResult = $this->skinScanService->predict($image, $tta);

            // 4. Parse response fields
            $predictedClassRaw = $aiResult['predicted_class'] ?? null;
            $enumClass = SkinDiseaseClass::tryFromRaw($predictedClassRaw);

            $updateData = [
                'predicted_class'   => $enumClass?->value ?? $predictedClassRaw,
                'predicted_label'   => $aiResult['predicted_label'] ?? null,
                'confidence'        => isset($aiResult['confidence']) ? (float) $aiResult['confidence'] : null,
                'inference_time_ms' => isset($aiResult['inference_time_ms']) ? (float) $aiResult['inference_time_ms'] : null,
                'tta_used'          => $aiResult['tta_used'] ?? $tta,
                'raw_response'      => $aiResult,
                'status'            => ScanStatus::COMPLETED->value,
            ];

            $this->diagnosisRepository->update($diagnosis, $updateData);

            return $diagnosis->fresh();
        } catch (Exception $e) {
            Log::error('Skin scan processing failed', [
                'diagnosis_id' => $diagnosis->id,
                'error'        => $e->getMessage(),
            ]);

            $this->diagnosisRepository->update($diagnosis, [
                'status'        => ScanStatus::FAILED->value,
                'error_message' => $e->getMessage(),
            ]);

            return $diagnosis->fresh();
        }
    }
}
