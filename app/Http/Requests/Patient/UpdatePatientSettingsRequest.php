<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'age'              => ['nullable', 'integer', 'min:1', 'max:120'],
            'blood_group'      => ['nullable', 'string', 'max:10'],
            'skin_type'        => ['nullable', 'string', 'max:50'],
            'conditions'       => ['nullable', 'array'],
            'conditions.*'     => ['string'],
            'active_allergies' => ['nullable', 'array'],
            'active_allergies.*' => ['string'],
            'settings'         => ['nullable', 'array'],
        ];
    }
}
