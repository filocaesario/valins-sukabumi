<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Pilihan posko/homebase, sama dengan opsi pada formulir registrasi.
     *
     * @var array<string, string>
     */
    public const HOMEBASES = [
        'Telkom Akses Sukabumi - Jl. R.E. Martadinata No. 24, Gunungparang, Kecamatan Cikole, Kota Sukabumi, Jawa Barat.' => 'Telkom Akses Sukabumi (Kantor Witel)',
        'Plasa Telkom Cibadak - Jl. Suryakencana No.123, Cibadak, Kec. Cibadak, Kabupaten Sukabumi' => 'Plasa Telkom Cibadak',
        'Kantor Sentral Cicurug - Jl. Siliwangi' => 'Kantor Sentral Cicurug',
        'Sub-Unit Palabuhanratu - Komplek Perkantoran' => 'Sub-Unit Palabuhanratu',
    ];

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $homebases = self::HOMEBASES;
        if ($user->homebase && ! array_key_exists($user->homebase, $homebases)) {
            $homebases = [$user->homebase => $user->homebase] + $homebases;
        }

        return view('profile.edit', [
            'user' => $user,
            'homebases' => $homebases,
            'activeSessions' => $this->activeSessions($request),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Upload a new profile photo.
     */
    public function updateAvatar(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'avatar.image' => 'Berkas harus berupa gambar.',
            'avatar.mimes' => 'Format foto harus JPG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $user = $request->user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $user->forceFill([
            'avatar_path' => $request->file('avatar')->store('avatars', 'public'),
        ])->save();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Foto profil berhasil diperbarui.',
                'avatar_url' => $user->avatarUrl(),
                'has_avatar' => true,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }

    /**
     * Remove the profile photo.
     */
    public function destroyAvatar(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $user = $request->user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->forceFill(['avatar_path' => null])->save();
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Foto profil berhasil dihapus.',
                'avatar_url' => null,
                'has_avatar' => false,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-removed');
    }

    /**
     * Save notification preferences.
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $request->user()->forceFill([
            'notification_preferences' => [
                'alert_redaman' => $request->boolean('alert_redaman'),
                'dispatch_bot' => $request->boolean('dispatch_bot'),
                'weekly_audit' => $request->boolean('weekly_audit'),
            ],
        ])->save();

        return Redirect::route('profile.edit')->with('status', 'notifications-updated');
    }

    /**
     * Sign out another active session of the current user.
     */
    public function destroySession(Request $request, string $sessionId): RedirectResponse
    {
        abort_if($sessionId === $request->session()->getId(), 422, 'Sesi aktif tidak dapat diputus dari sini.');

        DB::table(config('session.table', 'sessions'))
            ->where('id', $sessionId)
            ->where('user_id', $request->user()->id)
            ->delete();

        return Redirect::route('profile.edit')->with('status', 'session-revoked');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Daftar sesi login aktif milik pengguna (hanya bila driver sesi = database).
     *
     * @return array<int, array<string, mixed>>
     */
    private function activeSessions(Request $request): array
    {
        if (config('session.driver') !== 'database') {
            return [[
                'id' => $request->session()->getId(),
                'device' => $this->describeAgent((string) $request->userAgent()),
                'ip' => $request->ip(),
                'last_active' => 'Sekarang',
                'is_current' => true,
            ]];
        }

        $currentId = $request->session()->getId();

        return DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn ($row) => [
                'id' => $row->id,
                'device' => $this->describeAgent((string) $row->user_agent),
                'ip' => $row->ip_address,
                'last_active' => \Illuminate\Support\Carbon::createFromTimestamp($row->last_activity)
                    ->locale('id')
                    ->diffForHumans(),
                'is_current' => $row->id === $currentId,
            ])
            ->all();
    }

    /**
     * Ringkas user agent menjadi "Perangkat • Peramban".
     */
    private function describeAgent(string $agent): array
    {
        $os = match (true) {
            str_contains($agent, 'Windows') => 'Windows',
            str_contains($agent, 'Android') => 'Android',
            str_contains($agent, 'iPhone'), str_contains($agent, 'iPad') => 'iOS',
            str_contains($agent, 'Mac OS X') => 'macOS',
            str_contains($agent, 'Linux') => 'Linux',
            default => 'Perangkat tidak dikenal',
        };

        $browser = match (true) {
            str_contains($agent, 'Edg/') => 'Microsoft Edge',
            str_contains($agent, 'OPR/'), str_contains($agent, 'Opera') => 'Opera',
            str_contains($agent, 'Firefox') => 'Firefox',
            str_contains($agent, 'Chrome') => 'Google Chrome',
            str_contains($agent, 'Safari') => 'Safari',
            default => 'Peramban tidak dikenal',
        };

        return [
            'label' => $os.' • '.$browser,
            'mobile' => in_array($os, ['Android', 'iOS'], true),
        ];
    }
}
