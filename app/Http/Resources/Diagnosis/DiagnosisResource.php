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
        $rawResponse = $this->raw_response ?? [];

        return [
            'id'                     => $this->id,
            'user_id'                => $this->user_id,
            'image_url'              => $this->image_url,
            'predicted_class'        => $enumClass?->value ?? (is_string($this->predicted_class) ? $this->predicted_class : null),
            'predicted_label'        => $this->predicted_label ?? $enumClass?->label(),
            'label_ar'               => $enumClass?->labelAr(),
            'is_malignant'           => $enumClass?->isMalignant() ?? false,
            'confidence'             => $this->confidence,
            'confidence_percentage'      => $this->confidence ? round($this->confidence * 100, 2) . '%' : null,
            'inference_time_ms'      => $this->inference_time_ms,
            'tta_used'               => (bool) $this->tta_used,
            'status'                 => $this->status?->value ?? $this->status,
            'status_label'           => $this->status?->label(),
            'error_message'          => $this->error_message,
            'top_3'                  => $rawResponse['top_3'] ?? [],
            'raw_response'           => $rawResponse,
            'user'                   => new UserResource($this->whenLoaded('user')),
            'created_at'             => $this->created_at?->toIso8601String(),
            'updated_at'             => $this->updated_at?->toIso8601String(),
        ];
    }
}
