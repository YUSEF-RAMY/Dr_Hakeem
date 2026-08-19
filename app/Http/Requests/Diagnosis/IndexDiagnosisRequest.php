<?php

namespace App\Http\Requests\Diagnosis;

use App\Enums\ScanStatus;
use App\Enums\SkinDiseaseClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexDiagnosisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'          => ['nullable', 'string', Rule::enum(ScanStatus::class)],
            'predicted_class' => ['nullable', 'string', Rule::enum(SkinDiseaseClass::class)],
            'per_page'        => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
