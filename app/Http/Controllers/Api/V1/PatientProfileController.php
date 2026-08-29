<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Patient\UpdatePatientSettingsRequest;
use App\Http\Resources\Patient\PatientProfileResource;
use App\Services\Patient\PatientProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientProfileController extends BaseController
{
    public function __construct(
        protected PatientProfileService $patientProfileService
    ) {}

    /**
     * Get authenticated patient profile.
     */
    public function profile(Request $request): JsonResponse
    {
        $profile = $this->patientProfileService->getProfile($request->user());

        return $this->sendResponse(
            new PatientProfileResource($profile),
            'Patient profile details retrieved successfully'
        );
    }

    /**
     * Update patient settings and medical profile attributes.
     */
    public function updateSettings(UpdatePatientSettingsRequest $request): JsonResponse
    {
        $profile = $this->patientProfileService->updateSettings(
            $request->user(),
            $request->validated()
        );

        return $this->sendResponse(
            new PatientProfileResource($profile),
            'Patient profile and settings updated successfully'
        );
    }
}
