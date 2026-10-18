<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view (Screen 3: Verifikasi OTP & Sandi Baru).
     */
    public function create(Request $request): View
    {
        $userId = session('otp_reset_user_id');
        $user = $userId ? User::find($userId) : null;

        if (! $user && $request->filled('email')) {
            $user = User::where('email', $request->email)->first();
        }

        return view('auth.reset-password', [
            'request' => $request,
            'user' => $user,
        ]);
    }

    /**
     * Handle an incoming new password request (OTP or Token based).
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        // 1. Check if user is using the 6-Digit OTP verification flow
        if ($request->filled('otp') || is_array($request->input('otp'))) {
            $rawOtp = $request->input('otp');
            $otp = is_array($rawOtp) ? implode('', array_filter($rawOtp, fn($v) => $v !== null && $v !== '')) : trim((string) $rawOtp);

            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $userId = session('otp_reset_user_id') ?? $request->input('user_id');
            $user = $userId ? User::find($userId) : null;

            if (! $user && $request->filled('email')) {
                $user = User::where('email', $request->email)->first();
            }

            if (! $user) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'redirect' => route('password.request'),
                        'message' => 'Sesi pemulihan tidak ditemukan atau telah kedaluwarsa. Silakan ajukan ulang.',
                    ], 422);
                }

                return redirect()->route('password.request')->withErrors([
                    'identity' => 'Sesi pemulihan tidak ditemukan atau telah kedaluwarsa. Silakan ajukan ulang.',
                ]);
            }

            // Retrieve cached OTP payload
            $cached = Cache::get("password_otp_user_{$user->id}") ?? Cache::get("password_otp_email_{$user->email}");

            if (! $cached || empty($cached['otp']) || (string) $cached['otp'] !== (string) $otp) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'errors' => [
                            'otp' => 'Kode OTP 6-digit tidak sesuai atau telah kedaluwarsa. Periksa kembali email Anda atau kirim ulang kode.',
                        ],
                    ], 422);
                }

                return back()->withInput($request->only('email', 'user_id', 'password', 'password_confirmation'))->withErrors([
                    'otp' => 'Kode OTP 6-digit tidak sesuai atau telah kedaluwarsa. Periksa kembali email Anda atau kirim ulang kode.',
                ]);
            }

            // Update user password securely
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));

            // Clean up cache & reset session
            Cache::forget("password_otp_user_{$user->id}");
            Cache::forget("password_otp_email_{$user->email}");
            session()->forget([
                'otp_reset_user_id',
                'otp_reset_email',
                'otp_reset_nik',
                'otp_reset_name',
                'otp_reset_phone',
            ]);

            // Authenticate user directly and redirect to dashboard with success message
            Auth::login($user);
            $request->session()->regenerate();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('dashboard'),
                    'message' => 'Kata sandi berhasil diperbarui! Anda telah otomatis masuk ke sistem.',
                ]);
            }

            return redirect()->route('dashboard')->with('status', 'Kata sandi berhasil diperbarui! Anda telah otomatis masuk ke sistem.');
        }

        // 2. Standard token fallback for legacy links and automated tests
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
