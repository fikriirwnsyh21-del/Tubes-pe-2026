<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'regex:/^[0-9]+$/', 'min:9', 'max:15'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Nomor WhatsApp / HP hanya boleh berisi angka (tidak boleh huruf atau karakter khusus).',
            'phone.min' => 'Nomor WhatsApp / HP minimal 9 digit angka.',
            'phone.max' => 'Nomor WhatsApp / HP maksimal 15 digit angka.',
        ];
    }
}
