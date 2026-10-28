<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Nama lengkap dikunci (data kedinasan), jadi tidak diterima dari formulir.
     * Formulir profil dan modal ubah email memakai rute yang sama, sehingga
     * tiap field memakai "sometimes".
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nickname' => ['sometimes', 'required', 'string', 'max:24'],
            'wa_phone' => ['sometimes', 'nullable', 'string', 'min:9', 'max:15', 'regex:/^[0-9]{9,15}$/'],
            'homebase' => ['sometimes', 'nullable', 'string', 'max:150'],
            'service_start_date' => ['sometimes', 'nullable', 'date'],
            'email' => [
                'sometimes',
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()?->id),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nickname.required' => 'Nama panggilan wajib diisi.',
            'nickname.max' => 'Nama panggilan maksimal 24 karakter.',
            'wa_phone.regex' => 'Nomor handphone wajib berupa angka murni (9-15 digit).',
            'wa_phone.min' => 'Nomor handphone minimal 9 digit.',
            'wa_phone.max' => 'Nomor handphone maksimal 15 digit.',
            'service_start_date.date' => 'Format tanggal mulai kedinasan tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan akun lain.',
            'email.email' => 'Format email tidak valid.',
        ];
    }
}
