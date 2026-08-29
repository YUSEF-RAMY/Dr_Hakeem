<?php

namespace App\Http\Requests\Diagnosis;

use Illuminate\Foundation\Http\FormRequest;

class ExplainDiagnosisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file'  => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'alpha' => ['nullable', 'numeric', 'between:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'The skin lesion image file is required.',
            'file.image'    => 'The uploaded file must be a valid image.',
            'file.mimes'    => 'Allowed image formats are: jpeg, png, jpg, webp.',
            'file.max'      => 'The image size must not exceed 10 MB.',
            'alpha.numeric' => 'The alpha opacity parameter must be a valid number between 0.0 and 1.0.',
            'alpha.between' => 'The alpha opacity parameter must be between 0.0 and 1.0.',
        ];
    }
}
