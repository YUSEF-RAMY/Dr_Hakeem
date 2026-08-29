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
            'predicted_class'            => $enumClass?->value ?? (is_string($this->predicted_class) ? $this->predicted_class : null),
            'predicted_label'            => $this->predicted_label ?? $enumClass?->label(),
            'explained_class'            => $this->explained_class,
            'explained_label'            => $this->explained_label,
            'explained_class_confidence' => $this->explained_class_confidence,
            'label_ar'                   => $enumClass?->labelAr(),
            'is_malignant'               => $enumClass?->isMalignant() ?? false,
            'confidence'                 => $this->confidence,
            'confidence_percentage'      => $this->confidence ? round($this->confidence * 100, 2) . '%' : null,
            'risk_level'                 => $riskLevelEnum?->value ?? (is_string($this->risk_level) ? $this->risk_level : 'low'),
            'risk_level_label'           => $riskLevelEnum?->label(),
            'badge_color'                => $riskLevelEnum?->badgeColor() ?? 'green',
            'inference_time_ms'          => $this->inference_time_ms,
            'severity_analysis'          => $this->severity_analysis ?? [],
            'tta_used'                   => (bool) $this->tta_used,
            'alpha'                      => $this->alpha ? (float) $this->alpha : null,
            'status'                     => $this->status?->value ?? $this->status,
            'status_label'               => $this->status?->label(),
            'error_message'              => $this->error_message,
            'top_predictions'            => $rawResponse['top_predictions'] ?? $rawResponse['top_3'] ?? [],
            'top_3'                      => $rawResponse['top_3'] ?? $rawResponse['top_predictions'] ?? [],
            'raw_response'               => $rawResponse,
            'user'                       => new UserResource($this->whenLoaded('user')),
            'created_at'                 => $this->created_at?->toIso8601String(),
            'updated_at'                 => $this->updated_at?->toIso8601String(),
        ];
    }
}
