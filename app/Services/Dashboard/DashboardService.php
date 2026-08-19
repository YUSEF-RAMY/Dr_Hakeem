<?php

namespace App\Services\Dashboard;

use App\Enums\RiskLevel;
use App\Enums\ScanStatus;
use App\Enums\SkinDiseaseClass;
use App\Models\Diagnosis;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStats(User $user): array
    {
        $baseQuery = Diagnosis::query();

        // If user is a patient, limit query to their own scans
        if (!$user->hasRole('admin') && !$user->hasRole('doctor')) {
            $baseQuery->where('user_id', $user->id);
        }

        $totalScans = (clone $baseQuery)->count();
        $completedScans = (clone $baseQuery)->where('status', ScanStatus::COMPLETED->value)->count();
        $failedScans = (clone $baseQuery)->where('status', ScanStatus::FAILED->value)->count();
        $highRiskScans = (clone $baseQuery)->whereIn('risk_level', [RiskLevel::HIGH->value, RiskLevel::CRITICAL->value])->count();

        // Calculate growth rate (current month vs previous month)
        $currentMonthCount = (clone $baseQuery)->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $lastMonthCount = (clone $baseQuery)->whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth(),
        ])->count();

        $growthRate = 0.0;
        if ($lastMonthCount > 0) {
            $growthRate = round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 2);
        } elseif ($currentMonthCount > 0) {
            $growthRate = 100.0;
        }

        // Calculate Accuracy Metrics
        $completedQuery = (clone $baseQuery)->where('status', ScanStatus::COMPLETED->value);
        $avgConfidence = (float) ($completedQuery->avg('confidence') ?? 0.0);
        $avgInferenceTime = (float) ($completedQuery->avg('inference_time_ms') ?? 0.0);

        // Disease Distribution
        $distributionRaw = (clone $baseQuery)
            ->whereNotNull('predicted_class')
            ->select('predicted_class', DB::raw('count(*) as count'))
            ->groupBy('predicted_class')
            ->pluck('count', 'predicted_class')
            ->toArray();

        $diseaseDistribution = [];
        foreach (SkinDiseaseClass::cases() as $diseaseCase) {
            $code = $diseaseCase->value;
            $diseaseDistribution[] = [
                'class'        => $code,
                'label'        => $diseaseCase->label(),
                'label_ar'     => $diseaseCase->labelAr(),
                'is_malignant' => $diseaseCase->isMalignant(),
                'count'        => $distributionRaw[$code] ?? 0,
            ];
        }

        // Recent Scans
        $recentScans = (clone $baseQuery)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return [
            'total_scans'     => $totalScans,
            'completed_scans' => $completedScans,
            'failed_scans'    => $failedScans,
            'high_risk_scans' => $highRiskScans,
            'growth_rate'     => $growthRate,
            'accuracy_metrics' => [
                'average_confidence'            => round($avgConfidence, 4),
                'average_confidence_percentage' => round($avgConfidence * 100, 2) . '%',
                'average_inference_time_ms'     => round($avgInferenceTime, 2),
            ],
            'disease_distribution' => $diseaseDistribution,
            'recent_scans'         => $recentScans,
        ];
    }
}
