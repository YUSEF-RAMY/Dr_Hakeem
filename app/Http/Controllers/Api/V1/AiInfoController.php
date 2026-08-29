<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\AI\AiInfoResource;
use App\Services\AI\SkinScanService;
use Illuminate\Http\JsonResponse;

class AiInfoController extends BaseController
{
    public function __construct(
        protected SkinScanService $skinScanService
    ) {}

    /**
     * Get info and operational health status of the external AI model.
     */
    public function info(): JsonResponse
    {
        $infoData = $this->skinScanService->getModelInfo();

        return $this->sendResponse(
            new AiInfoResource($infoData),
            'External AI model status and operational metadata retrieved successfully'
        );
    }
}
