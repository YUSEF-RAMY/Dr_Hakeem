<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'patient_code'     => $this->patient_code,
            'age'              => $this->age,
            'blood_group'      => $this->blood_group,
            'skin_type'        => $this->skin_type,
            'conditions'       => $this->conditions ?? [],
            'active_allergies' => $this->active_allergies ?? [],
            'settings'         => $this->settings ?? [],
            'user'             => new UserResource($this->whenLoaded('user')),
            'created_at'       => $this->created_at?->toIso8601String(),
            'updated_at'       => $this->updated_at?->toIso8601String(),
        ];
    }
}
