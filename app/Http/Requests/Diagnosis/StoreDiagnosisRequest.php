<?php

namespace App\Http\Requests\Diagnosis;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiagnosisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'tta'  => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'يرجى إرفاق صورة الفحص الجلدي',
            'file.image'    => 'الملف المرفق يجب أن يكون صورة',
            'file.mimes'    => 'أنواع الصور المقبولة هي: jpeg, png, jpg, webp',
            'file.max'      => 'حجم الصورة يجب أن لا يتجاوز 10 ميجابايت',
        ];
    }
}
