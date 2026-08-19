<?php

namespace App\Http\Resources\Dashboard;

use App\Http\Resources\Diagnosis\DiagnosisResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_scans'          => $this->resource['total_scans'] ?? 0,
            'completed_scans'      => $this->resource['completed_scans'] ?? 0,
            'failed_scans'         => $this->resource['failed_scans'] ?? 0,
            'high_risk_scans'      => $this->resource['high_risk_scans'] ?? 0,
            'growth_rate'          => $this->resource['growth_rate'] ?? 0.0,
            'accuracy_metrics'     => $this->resource['accuracy_metrics'] ?? [],
            'disease_distribution' => $this->resource['disease_distribution'] ?? [],
            'recent_scans'         => DiagnosisResource::collection($this->resource['recent_scans'] ?? []),
        ];
    }
}
