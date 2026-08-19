<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\Dashboard\DashboardStatsResource;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Get aggregated system stats, growth rate, accuracy metrics, and recent scans.
     */
    public function stats(Request $request): JsonResponse
    {
        $stats = $this->dashboardService->getStats($request->user());

        return $this->sendResponse(
            new DashboardStatsResource($stats),
            'إحصائيات لوحة التحكم لموديل دكتور حكيم'
        );
    }
}
