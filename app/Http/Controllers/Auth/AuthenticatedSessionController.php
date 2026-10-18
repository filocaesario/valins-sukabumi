<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Real-time verification of identity and credentials for debounced client-side validation.
     */
    public function checkCredentials(Request $request): \Illuminate\Http\JsonResponse
    {
        $identity = trim($request->input('identity', ''));
        $password = (string) $request->input('password', '');

        if ($identity === '') {
            return response()->json([
                'identity_valid' => false,
                'identity_message' => 'Kolom Email atau NIK wajib diisi.',
                'password_valid' => false,
                'password_message' => null,
            ]);
        }

        $isEmail = filter_var($identity, FILTER_VALIDATE_EMAIL);
        $hasLetters = preg_match('/[@a-zA-Z]/', $identity);

        if ($hasLetters && ! $isEmail) {
            return response()->json([
                'identity_valid' => false,
                'identity_message' => 'Format alamat email belum lengkap atau tidak valid.',
                'password_valid' => false,
                'password_message' => null,
            ]);
        }

        if (preg_match('/^\d+$/', $identity) && strlen($identity) < 6) {
            return response()->json([
                'identity_valid' => false,
                'identity_message' => 'Format NIK tidak valid. Masukkan nomor induk personel yang sesuai.',
                'password_valid' => false,
                'password_message' => null,
            ]);
        }

        // Fast path for identity-only check (ultra-fast sub-millisecond query, zero hydration overhead)
        if ($password === '') {
            $exists = \App\Models\User::where('email', $identity)
                ->orWhere('nik', $identity)
                ->exists();

            return response()->json([
                'identity_valid' => $exists,
                'identity_message' => $exists ? null : 'Kredensial NIK atau Email tidak ditemukan dalam data personel teknisi kami.',
                'password_valid' => null,
                'password_message' => null,
            ]);
        }

        // Full credential check (only when password is provided)
        $user = \App\Models\User::select('id', 'password')
            ->where('email', $identity)
            ->orWhere('nik', $identity)
            ->first();

        if (! $user) {
            return response()->json([
                'identity_valid' => false,
                'identity_message' => 'Kredensial NIK atau Email tidak ditemukan dalam data personel teknisi kami.',
                'password_valid' => false,
                'password_message' => null,
            ]);
        }

        if (strlen($password) < 8) {
            return response()->json([
                'identity_valid' => true,
                'identity_message' => null,
                'password_valid' => false,
                'password_message' => 'Kata sandi yang Anda masukkan tidak sesuai dengan kredensial akun.',
            ]);
        }

        $passwordMatches = \Illuminate\Support\Facades\Hash::check($password, $user->password);

        return response()->json([
            'identity_valid' => true,
            'identity_message' => null,
            'password_valid' => $passwordMatches,
            'password_message' => $passwordMatches ? null : 'Kata sandi yang Anda masukkan tidak sesuai dengan kredensial akun.',
        ]);
    }
}
