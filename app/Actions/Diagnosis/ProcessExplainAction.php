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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class ProcessExplainAction
{
    public function __construct(
        protected SaveUploadedImageAction $saveImageAction,
        protected SkinScanService $skinScanService,
        protected DiagnosisRepositoryInterface $diagnosisRepository
    ) {}

    public function execute(User $user, UploadedFile $image, float $alpha = 0.45): Diagnosis
    {
        // 1. Save uploaded skin image file
        $imagePath = $this->saveImageAction->execute($image);

        // 2. Fetch or generate patient code
        $patientProfile = $user->patientProfile;
        $patientCode = $patientProfile?->patient_code ?? ('PAT-' . strtoupper(substr(md5($user->id), 0, 6)));

        // 3. Create pending diagnosis record
        $diagnosis = $this->diagnosisRepository->create([
            'user_id'         => $user->id,
            'patient_id_code' => $patientCode,
            'image_path'      => $imagePath,
            'status'          => ScanStatus::PENDING->value,
            'alpha'           => $alpha,
            'tta_used'        => true,
        ]);

        try {
            // 4. Call External AI Service /explain endpoint
            $aiResult = $this->skinScanService->explain($image, $alpha);

            $predictedClassRaw = $aiResult['predicted_class'] ?? $aiResult['explained_class'] ?? null;
            $enumClass = SkinDiseaseClass::tryFromRaw($predictedClassRaw);
            $confidence = isset($aiResult['confidence']) ? (float) $aiResult['confidence'] : (isset($aiResult['explained_class_confidence']) ? (float) $aiResult['explained_class_confidence'] : null);

            $explainedClassRaw = $aiResult['explained_class'] ?? $predictedClassRaw;
            $explainedEnumClass = SkinDiseaseClass::tryFromRaw($explainedClassRaw);
            $explainedLabel = $aiResult['explained_label'] ?? $explainedEnumClass?->label();
            $explainedConfidence = isset($aiResult['explained_class_confidence']) ? (float) $aiResult['explained_class_confidence'] : $confidence;

            // 5. Decode and store base64 heatmap overlay image to disk
            $heatmapPath = null;
            if (!empty($aiResult['heatmap_base64'])) {
                $base64Data = $aiResult['heatmap_base64'];

                // Remove Data URI scheme if present (e.g., data:image/png;base64,)
                if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $type)) {
                    $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
                }

                $base64Data = str_replace(' ', '+', trim($base64Data));
                $decodedImageData = base64_decode($base64Data);

                if ($decodedImageData !== false && strlen($decodedImageData) > 0) {
                    Storage::disk('public')->makeDirectory('diagnoses/heatmaps');
                    $heatmapsDir = Storage::disk('public')->path('diagnoses/heatmaps');
                    if (file_exists($heatmapsDir)) {
                        @chmod($heatmapsDir, 0755);
                    }

                    $heatmapFilename = 'diagnoses/heatmaps/' . Str::uuid() . '.png';
                    Storage::disk('public')->put($heatmapFilename, $decodedImageData, 'public');
                    $fullHeatmapPath = Storage::disk('public')->path($heatmapFilename);

                    if (file_exists($fullHeatmapPath)) {
                        @chmod($fullHeatmapPath, 0644);
                    }

                    $heatmapPath = $heatmapFilename;
                }
            }

            // 6. Compute Risk Level & Severity Analysis
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
                'overlay_alpha'       => $alpha,
            ];

            // 7. Clean raw_response to avoid storing massive base64 payload in DB
            $cleanRawResponse = $aiResult;
            if (isset($cleanRawResponse['heatmap_base64'])) {
                $cleanRawResponse['heatmap_url'] = $heatmapPath ? Storage::disk('public')->url($heatmapPath) : null;
                unset($cleanRawResponse['heatmap_base64']);
            }

            $updateData = [
                'predicted_class'            => $enumClass?->value ?? $predictedClassRaw,
                'predicted_label'            => $aiResult['predicted_label'] ?? $enumClass?->label(),
                'explained_class'            => $explainedEnumClass?->value ?? $explainedClassRaw,
                'explained_label'            => $explainedLabel,
                'explained_class_confidence' => $explainedConfidence,
                'confidence'                 => $confidence,
                'risk_level'                 => $riskLevel->value,
                'inference_time_ms'          => isset($aiResult['inference_time_ms']) ? (float) $aiResult['inference_time_ms'] : null,
                'severity_analysis'          => $severityAnalysis,
                'heatmap_path'               => $heatmapPath,
                'alpha'                      => $alpha,
                'raw_response'               => $cleanRawResponse,
                'status'                     => ScanStatus::COMPLETED->value,
            ];

            $this->diagnosisRepository->update($diagnosis, $updateData);

            return $diagnosis->fresh();
        } catch (Exception $e) {
            Log::error('ProcessExplainAction Exception', [
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
            RiskLevel::CRITICAL, RiskLevel::HIGH => 'تنبيه: تشير تحليلات الذكاء الاصطناعي والخريطة الحرارية إلى احتمال وجود آفة جلدية قد تكون خطيرة (' . ($diseaseClass?->labelAr() ?? 'سرطانية') . '). يُوصى بشدة بمراجعة طبيب أخصائي أمراض جلدية لإجراء فحص سريري وخزعة في أقرب وقت.',
            RiskLevel::MODERATE => 'النتيجة تشير إلى احتمال آفة جلدية يحسن متابعتها. يفضل استشارة طبيب جلدية لإجراء فحص دقيق للآفة ومتابعة الخريطة الحرارية.',
            RiskLevel::LOW => 'النتيجة تشير إلى آفة حميدة غالباً (' . ($diseaseClass?->labelAr() ?? 'غير خطيرة') . '). يُنصح بمراقبة أي تغيرات في الشكل أو اللون وتطبيق واقي الشمس بصورة منتظمة.',
        };
    }

    protected function generateEnglishRecommendation(RiskLevel $riskLevel, ?SkinDiseaseClass $diseaseClass): string
    {
        return match ($riskLevel) {
            RiskLevel::CRITICAL, RiskLevel::HIGH => 'Warning: AI analysis and heatmap overlay suggest a potentially high-risk lesion (' . ($diseaseClass?->label() ?? 'malignant') . '). Immediate consultation with a dermatologist for clinical evaluation is strongly recommended.',
            RiskLevel::MODERATE => 'Moderate risk detected. Dermatological follow-up is recommended to evaluate the lesion and review the overlay heatmap.',
            RiskLevel::LOW => 'Low risk lesion detected (' . ($diseaseClass?->label() ?? 'benign') . '). Routine monitoring and general skin protection are advised.',
        };
    }
}
