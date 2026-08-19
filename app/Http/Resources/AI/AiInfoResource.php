<?php

namespace App\Http\Resources\AI;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AiInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'  => $this->resource['status'] ?? 'unknown',
            'details' => $this->resource['details'] ?? null,
            'message' => $this->resource['message'] ?? null,
        ];
    }
}
