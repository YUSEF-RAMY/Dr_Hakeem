<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Diagnosis\ExplainDiagnosisRequest;
use App\Http\Requests\Diagnosis\IndexDiagnosisRequest;
use App\Http\Requests\Diagnosis\StoreDiagnosisRequest;
use App\Http\Resources\Diagnosis\DiagnosisCollection;
use App\Http\Resources\Diagnosis\DiagnosisResource;
use App\Models\Diagnosis;
use App\Services\Diagnosis\DiagnosisService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class DiagnosisController extends BaseController
{
    use AuthorizesRequests;

    public function __construct(
        protected DiagnosisService $diagnosisService
    ) {}

    /**
     * Upload skin image and execute AI diagnosis scan.
     */
    public function store(StoreDiagnosisRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $tta = $request->boolean('tta', true);

        $diagnosis = $this->diagnosisService->processScan($request->user(), $file, $tta);

        return $this->sendResponse(
            new DiagnosisResource($diagnosis->load('user')),
            'Skin image processed and diagnosed successfully via Dr. Hakeem AI model',
            201
        );
    }

    /**
     * Upload skin image and generate AI explainability heatmap overlay.
     */
    public function explain(ExplainDiagnosisRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $alpha = (float) $request->input('alpha', 0.45);

        $diagnosis = $this->diagnosisService->processExplain($request->user(), $file, $alpha);

        return $this->sendResponse(
            new DiagnosisResource($diagnosis->load('user')),
            'Skin image processed and heatmap overlay generated successfully via Dr. Hakeem AI model',
            201
        );
    }

    /**
     * Alias endpoint for POST /api/v1/diagnoses/process
     */
    public function process(StoreDiagnosisRequest $request): JsonResponse
    {
        return $this->store($request);
    }

    /**
     * Get paginated skin scan diagnoses.
     */
    public function index(IndexDiagnosisRequest $request): JsonResponse
    {
        $filters = $request->only(['status', 'predicted_class']);
        $perPage = (int) $request->input('per_page', 15);

        $diagnoses = $this->diagnosisService->getUserDiagnoses($request->user(), $filters, $perPage);

        return $this->sendResponse(
            new DiagnosisCollection($diagnoses),
            'Skin scan diagnoses history retrieved successfully'
        );
    }

    /**
     * Alias endpoint for GET /api/v1/diagnoses/history
     */
    public function history(IndexDiagnosisRequest $request): JsonResponse
    {
        return $this->index($request);
    }

    /**
     * Get single skin scan diagnosis details.
     */
    public function show(Diagnosis $diagnosis): JsonResponse
    {
        $this->authorize('view', $diagnosis);

        return $this->sendResponse(
            new DiagnosisResource($diagnosis->load('user')),
            'Skin scan diagnosis details retrieved successfully'
        );
    }

    /**
     * Delete skin scan diagnosis record & image.
     */
    public function destroy(Diagnosis $diagnosis): JsonResponse
    {
        $this->authorize('delete', $diagnosis);

        $this->diagnosisService->deleteDiagnosis($diagnosis);

        return $this->sendResponse(null, 'Diagnosis record and associated files deleted successfully');
    }
}
