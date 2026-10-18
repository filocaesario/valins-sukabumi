<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identity' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Custom Indonesian validation error messages.
     */
    public function messages(): array
    {
        return [
            'identity.required' => 'Kolom Email atau NIK wajib diisi.',
            'email.required' => 'Kolom Email atau NIK wajib diisi.',
            'password.required' => 'Kata sandi yang Anda masukkan tidak sesuai dengan kredensial akun.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginInput = trim($this->input('identity') ?? $this->input('email') ?? '');
        
        if (empty($loginInput)) {
            throw ValidationException::withMessages([
                'identity' => 'Kolom Email atau NIK wajib diisi.',
            ]);
        }

        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        $credentials = [
            $isEmail ? 'email' : 'nik' => $loginInput,
            'password' => (string) $this->input('password'),
        ];

        $remember = $this->boolean('remember') || $this->boolean('rememberSession');

        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey());

            $userExists = \App\Models\User::where('email', $loginInput)
                ->orWhere('nik', $loginInput)
                ->exists();

            if (! $userExists) {
                throw ValidationException::withMessages([
                    'identity' => 'Kredensial NIK atau Email tidak ditemukan dalam data personel teknisi kami.',
                ]);
            }

            throw ValidationException::withMessages([
                'password' => 'Kata sandi yang Anda masukkan tidak sesuai dengan kredensial akun.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        $errorMsg = 'Terlalu banyak upaya masuk. Silakan coba lagi dalam ' . $seconds . ' detik.';

        throw ValidationException::withMessages([
            'identity' => $errorMsg,
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $loginInput = trim($this->input('identity') ?? $this->input('email') ?? '');
        return Str::transliterate(Str::lower($loginInput).'|'.$this->ip());
    }
}
