<?php

namespace App\Http\Resources\Diagnosis;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiagnosisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $enumClass = $this->predicted_class;
        $riskLevelEnum = $this->risk_level;
        $rawResponse = $this->raw_response ?? [];

        return [
            'id'                         => $this->id,
            'user_id'                    => $this->user_id,
            'patient_id_code'            => $this->patient_id_code,
            'image_url'                  => $this->image_url,
            'heatmap_url'                => $this->heatmap_url,
            'overlay_url'                => $this->overlay_url,
            'predicted_class'            => $enumClass?->value ?? (is_string($this->predicted_class) ? $this->predicted_class : null),
            'predicted_label'            => $this->predicted_label ?? $enumClass?->label(),
            'explained_class'                   => $this->explained_class,
            'explained_label'                   => $this->explained_label,
            'explained_class_confidence'        => $this->toPercentage($this->explained_class_confidence),
            'explained_class_confidence_percentage' => $this->toPercentageString($this->explained_class_confidence),
            'label_ar'                   => $enumClass?->labelAr(),
            'is_malignant'               => $enumClass?->isMalignant() ?? false,
            'confidence'                 => $this->toPercentage($this->confidence),
            'confidence_percentage'      => $this->toPercentageString($this->confidence),
            'risk_level'                 => $riskLevelEnum?->value ?? (is_string($this->risk_level) ? $this->risk_level : 'low'),
            'risk_level_label'           => $riskLevelEnum?->label(),
            'badge_color'                => $riskLevelEnum?->badgeColor() ?? 'green',
            'inference_time_ms'          => $this->inference_time_ms,
            'severity_analysis'          => $this->formatSeverityAnalysis($this->severity_analysis ?? []),
            'tta_used'                   => (bool) $this->tta_used,
            'alpha'                      => $this->alpha ? (float) $this->alpha : null,
            'status'                     => $this->status?->value ?? $this->status,
            'status_label'               => $this->status?->label(),
            'error_message'              => $this->error_message,
            'top_predictions'            => $this->formatTopPredictions($rawResponse['top_predictions'] ?? $rawResponse['top_3'] ?? []),
            'raw_response'               => $this->formatRawResponse($rawResponse),
            'user'                       => new UserResource($this->whenLoaded('user')),
            'created_at'                 => $this->created_at?->toIso8601String(),
            'updated_at'                 => $this->updated_at?->toIso8601String(),
        ];
    }

    protected function formatSeverityAnalysis(array $severity): array
    {
        if (isset($severity['confidence_score'])) {
            $severity['confidence_score'] = $this->toPercentage($severity['confidence_score']);
        }

        return $severity;
    }

    protected function formatRawResponse(array $raw): array
    {
        if (isset($raw['confidence'])) {
            $raw['confidence_percentage'] = $this->toPercentageString($raw['confidence']);
            $raw['confidence'] = $this->toPercentage($raw['confidence']);
        }

        if (isset($raw['explained_class_confidence'])) {
            $raw['explained_class_confidence_percentage'] = $this->toPercentageString($raw['explained_class_confidence']);
            $raw['explained_class_confidence'] = $this->toPercentage($raw['explained_class_confidence']);
        }

        if (isset($raw['top_predictions']) && is_array($raw['top_predictions'])) {
            $raw['top_predictions'] = $this->formatTopPredictions($raw['top_predictions']);
        }

        return $raw;
    }

    protected function formatTopPredictions(array $topPredictions): array
    {
        return array_map(function ($item) {
            $rawConfidence = $item['confidence'] ?? $item['probability'] ?? null;

            $item['confidence'] = $this->toPercentage($rawConfidence);
            $item['confidence_percentage'] = $this->toPercentageString($rawConfidence);

            return $item;
        }, $topPredictions);
    }

    protected function toPercentage(?float $value): ?float
    {
        return $value !== null ? (float) round($value * 100, 2) : null;
    }

    protected function toPercentageString(?float $value): ?string
    {
        return $value !== null ? round($value * 100, 2) . '%' : null;
    }
}
