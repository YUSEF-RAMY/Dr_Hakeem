<?php

namespace App\Actions\Diagnosis;

use App\Enums\RiskLevel;
use App\Enums\ScanStatus;
use App\Enums\SkinDiseaseClass;
use App\Models\Diagnosis;
use App\Models\User;
use App\Repositories\Contracts\DiagnosisRepositoryInterface;
use App\Services\AI\SkinScanService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessScanAction
{
    public function __construct(
        protected SaveUploadedImageAction $saveImageAction,
        protected SkinScanService $skinScanService,
        protected DiagnosisRepositoryInterface $diagnosisRepository
    ) {}

    public function execute(User $user, UploadedFile $image, bool $tta = true): Diagnosis
    {
        // 1. Save uploaded image file
        $imagePath = $this->saveImageAction->execute($image);

        // 2. Fetch patient code
        $patientProfile = $user->patientProfile;
        $patientCode = $patientProfile?->patient_code ?? ('PAT-' . strtoupper(substr(md5($user->id), 0, 6)));

        // 3. Create pending diagnosis
        $diagnosis = $this->diagnosisRepository->create([
            'user_id'         => $user->id,
            'patient_id_code' => $patientCode,
            'image_path'      => $imagePath,
            'status'          => ScanStatus::PENDING->value,
            'tta_used'        => $tta,
        ]);

        try {
            // 4. Call External AI Service
            $aiResult = $this->skinScanService->predict($image, $tta);

            $predictedClassRaw = $aiResult['predicted_class'] ?? null;
            $enumClass = SkinDiseaseClass::tryFromRaw($predictedClassRaw);
            $confidence = isset($aiResult['confidence']) ? (float) $aiResult['confidence'] : null;

            // 5. Compute Risk Level & Severity Analysis
            $riskLevel = RiskLevel::compute($enumClass, $confidence);

            $severityAnalysis = [
                'risk_level'          => $riskLevel->value,
                'risk_label_ar'       => $riskLevel->label(),
                'badge_color'         => $riskLevel->badgeColor(),
                'is_malignant'        => $enumClass?->isMalignant() ?? false,
                'recommendation_ar'   => $this->generateArabicRecommendation($riskLevel, $enumClass),
                'recommendation_en'   => $this->generateEnglishRecommendation($riskLevel, $enumClass),
                'confidence_score'    => $confidence,
                'inference_time_ms'   => $aiResult['inference_time_ms'] ?? null,
            ];

            $updateData = [
                'predicted_class'   => $enumClass?->value ?? $predictedClassRaw,
                'predicted_label'   => $aiResult['predicted_label'] ?? $enumClass?->label(),
                'confidence'        => $confidence,
                'risk_level'        => $riskLevel->value,
                'inference_time_ms' => isset($aiResult['inference_time_ms']) ? (float) $aiResult['inference_time_ms'] : null,
                'severity_analysis' => $severityAnalysis,
                'tta_used'          => $aiResult['tta_used'] ?? $tta,
                'raw_response'      => $aiResult,
                'status'            => ScanStatus::COMPLETED->value,
            ];

            $this->diagnosisRepository->update($diagnosis, $updateData);

            return $diagnosis->fresh();
        } catch (Exception $e) {
            Log::error('ProcessScanAction Exception', [
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

    protected function generateArabicRecommendation(RiskLevel $riskLevel, ?SkinDiseaseClass $diseaseClass): string
    {
        return match ($riskLevel) {
            RiskLevel::CRITICAL, RiskLevel::HIGH => 'تنبيه: تشير تحليلات الذكاء الاصطناعي إلى احتمال وجود آفة جلدية قد تكون خطيرة (' . ($diseaseClass?->labelAr() ?? 'سرطانية') . '). يُوصى بشدة بمراجعة طبيب أخصائي أمراض جلدية لإجراء فحص سريري وخزعة في أقرب وقت.',
            RiskLevel::MODERATE => 'النتيجة تشير إلى احتمال آفة جلدية يحسن متابعتها. يفضل استشارة طبيب جلدية لإجراء فحص دقيق للآفة.',
            RiskLevel::LOW => 'النتيجة تشير إلى آفة حميدة غالباً (' . ($diseaseClass?->labelAr() ?? 'غير خطيرة') . '). يُنصح بمراقبة أي تغيرات في الشكل أو اللون وتطبيق واقي الشمس بصورة منتظمة.',
        };
    }

    protected function generateEnglishRecommendation(RiskLevel $riskLevel, ?SkinDiseaseClass $diseaseClass): string
    {
        return match ($riskLevel) {
            RiskLevel::CRITICAL, RiskLevel::HIGH => 'Warning: AI analysis suggests a potentially high-risk lesion (' . ($diseaseClass?->label() ?? 'malignant') . '). Immediate consultation with a dermatologist for clinical evaluation is strongly recommended.',
            RiskLevel::MODERATE => 'Moderate risk detected. Dermatological follow-up is recommended to evaluate the lesion.',
            RiskLevel::LOW => 'Low risk lesion detected (' . ($diseaseClass?->label() ?? 'benign') . '). Routine monitoring and general skin protection are advised.',
        };
    }
}
