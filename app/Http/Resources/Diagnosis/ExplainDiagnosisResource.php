<?php

namespace App\Http\Resources\Diagnosis;

use Illuminate\Http\Request;

class ExplainDiagnosisResource extends ScanDiagnosisResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base = parent::toArray($request);

        return array_merge($base, [
            'heatmap_url'                => $this->heatmap_url,
            'overlay_url'                => $this->overlay_url,
            'explained_class'            => $this->explained_class,
            'explained_label'            => $this->explained_label,
            'explained_class_confidence' => $this->toPercentage($this->explained_class_confidence),
            'explained_class_confidence_percentage' => $this->toPercentageString($this->explained_class_confidence),
            'alpha'                      => $this->alpha ? (float) $this->alpha : null,
        ]);
    }
}
