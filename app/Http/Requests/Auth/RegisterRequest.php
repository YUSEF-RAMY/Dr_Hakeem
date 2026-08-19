<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['nullable', 'string', 'in:patient,doctor'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'الاسم مطلوب',
            'email.required'    => 'البريد الإلكتروني مطلوب',
            'email.email'       => 'يرجى كتابة بريد إلكتروني صحيح',
            'email.unique'      => 'هذا البريد الإلكتروني مستخدم بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min'      => 'يجب أن لا تقل كلمة المرور عن 8 أحرف',
            'password.confirmed'=> 'تأكيد كلمة المرور غير متطابق',
        ];
    }
}
