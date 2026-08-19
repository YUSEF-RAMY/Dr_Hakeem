<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Patient\PatientProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'roles'           => $this->whenLoaded('roles', fn() => $this->roles->pluck('name')),
            'patient_profile' => new PatientProfileResource($this->whenLoaded('patientProfile')),
            'created_at'      => $this->created_at?->toIso8601String(),
        ];
    }
}
