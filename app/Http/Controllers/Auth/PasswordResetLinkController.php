<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpResetPasswordMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'identity' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'recovery_method' => ['nullable', 'string', 'in:email,otp'],
        ]);

        $identifier = trim($request->input('identity') ?? $request->input('email') ?? '');

        if (empty($identifier)) {
            return back()->withInput()->withErrors([
                'identity' => 'Silakan masukkan NIK Karyawan atau Email Korporat Anda.',
                'email' => 'Silakan masukkan NIK Karyawan atau Email Korporat Anda.',
            ]);
        }

        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);
        $user = $isEmail
            ? User::where('email', $identifier)->first()
            : User::where('nik', $identifier)->first();

        if (! $user) {
            return back()->withInput()->withErrors([
                'identity' => 'Data NIK atau Email tidak ditemukan pada sistem SIM VALINS Telkom Akses Sukabumi.',
                'email' => 'Data NIK atau Email tidak ditemukan pada sistem SIM VALINS Telkom Akses Sukabumi.',
            ]);
        }

        // Generate 6-digit numeric OTP
        $otp = (string) random_int(100000, 999999);

        // Save OTP to Cache for 15 minutes (with primitive array values to prevent incomplete class serialization)
        $otpPayload = [
            'otp' => $otp,
            'user_id' => $user->id,
            'email' => $user->email,
            'nik' => $user->nik,
            'name' => $user->name,
            'phone' => $user->wa_phone,
            'created_at' => now()->timestamp,
        ];

        Cache::put("password_otp_user_{$user->id}", $otpPayload, now()->addMinutes(15));
        Cache::put("password_otp_email_{$user->email}", $otpPayload, now()->addMinutes(15));

        // Create reset token quietly in database without sending Laravel's default unstyled notification email
        try {
            Password::broker()->createToken($user);
        } catch (\Throwable $e) {
            Log::info('Password broker token creation: ' . $e->getMessage());
        }

        // Send official Telkom Akses OTP email via SMTP
        try {
            Mail::to($user->email)->send(new OtpResetPasswordMail($user, $otp));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email OTP: ' . $e->getMessage());
        }

        // Store context in session for Screen 3
        session([
            'otp_reset_user_id' => $user->id,
            'otp_reset_email' => $user->email,
            'otp_reset_nik' => $user->nik,
            'otp_reset_name' => $user->name,
            'otp_reset_phone' => $user->wa_phone,
        ]);

        return redirect()->route('password.otp')->with('status', 'Kode OTP 6-digit telah berhasil dikirim ke email kedinasan Anda.');
    }

    /**
     * Resend OTP code.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $userId = session('otp_reset_user_id') ?? $request->input('user_id');
        $user = $userId ? User::find($userId) : null;

        if (! $user && $request->filled('email')) {
            $user = User::where('email', $request->email)->first();
        }

        if (! $user) {
            return redirect()->route('password.request')->withErrors([
                'identity' => 'Sesi pemulihan telah berakhir. Silakan masukkan kembali identitas Anda.'
            ]);
        }

        // Throttle resending to 1 per 60 seconds
        $throttleKey = 'resend_otp_' . $user->id;
        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Harap tunggu {$seconds} detik sebelum meminta kirim ulang kode OTP.");
        }
        RateLimiter::hit($throttleKey, 60);

        $otp = (string) random_int(100000, 999999);

        $otpPayload = [
            'otp' => $otp,
            'user_id' => $user->id,
            'email' => $user->email,
            'nik' => $user->nik,
            'name' => $user->name,
            'phone' => $user->wa_phone,
            'created_at' => now()->timestamp,
        ];

        Cache::put("password_otp_user_{$user->id}", $otpPayload, now()->addMinutes(15));
        Cache::put("password_otp_email_{$user->email}", $otpPayload, now()->addMinutes(15));

        try {
            Mail::to($user->email)->send(new OtpResetPasswordMail($user, $otp));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim ulang email OTP: ' . $e->getMessage());
        }

        return back()->with('status', 'Kode OTP 6-digit baru telah berhasil dikirim ke email kedinasan Anda.');
    }
}
