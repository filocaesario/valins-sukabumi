@php
    $mfaMethod = trim((string) $user->mfa_method);
    $mfaActive = $mfaMethod !== '' && strtolower($mfaMethod) !== 'none';
@endphp

<div class="flex items-center justify-between border-b pb-space-sm border-transparent">
    <div class="flex flex-col">
        <h3 class="font-headline-md text-headline-md text-on-surface">Keamanan &amp; Autentikasi Pengguna</h3>
        <p class="font-body-sm text-body-sm text-secondary">Kelola kata sandi akun dan pantau perangkat yang sedang masuk ke SIM VALINS.</p>
    </div>
    <span class="material-symbols-outlined text-primary text-headline-md">enhanced_encryption</span>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
    {{-- Kartu kata sandi --}}
    <div class="bg-surface-container-low p-space-md rounded-st-xl flex flex-col justify-between gap-space-md">
        <div class="flex items-start gap-space-sm">
            <div class="w-10 h-10 rounded-st-lg bg-surface-container-highest text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">password</span>
            </div>
            <div class="flex flex-col">
                <span class="font-label-lg text-label-lg font-bold text-on-surface">Kata Sandi Akun</span>
                <span class="font-body-xs text-body-xs text-secondary mt-0.5">Gunakan kombinasi huruf, angka, dan simbol. Anda perlu memasukkan kata sandi saat ini untuk menggantinya.</span>
            </div>
        </div>
        <button type="button" id="btnChangePassword" @click="passwordModal = true"
                class="w-full py-2 px-3 bg-surface-container-highest hover:bg-secondary-container text-on-surface font-label-md text-label-md font-semibold rounded-st-lg flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-body-md">lock_reset</span>
            <span>Ubah Password</span>
        </button>
    </div>

    {{-- Kartu 2FA --}}
    <div class="bg-surface-container-low p-space-md rounded-st-xl flex flex-col justify-between gap-space-md">
        <div class="flex items-start gap-space-sm">
            <div class="w-10 h-10 rounded-st-lg {{ $mfaActive ? 'bg-emerald-100 text-emerald-700' : 'bg-surface-container-highest text-secondary' }} flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">phonelink_lock</span>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    <span class="font-label-lg text-label-lg font-bold text-on-surface">{{ $mfaActive ? $mfaMethod : 'Autentikasi Dua Faktor' }}</span>
                    <span class="{{ $mfaActive ? 'bg-emerald-50 text-emerald-800' : 'bg-surface-container-highest text-secondary' }} text-label-sm font-semibold px-2 py-0.5 rounded-st">{{ $mfaActive ? 'Aktif' : 'Belum Aktif' }}</span>
                </div>
                <span class="font-body-xs text-body-xs text-secondary mt-0.5">Lapisan verifikasi tambahan saat masuk. Pengaturan 2FA belum tersedia di versi aplikasi ini.</span>
            </div>
        </div>
        <button type="button" disabled
                class="w-full py-2 px-3 bg-surface-container-highest text-on-surface font-label-md text-label-md font-semibold rounded-st-lg flex items-center justify-center gap-1.5 opacity-50 cursor-not-allowed">
            <span class="material-symbols-outlined text-body-md">qr_code_scanner</span>
            <span>Atur Autentikator</span>
        </button>
    </div>
</div>

{{-- Daftar sesi --}}
<div class="flex flex-col gap-space-xs mt-space-sm">
    <span class="font-label-md text-label-md font-bold text-on-surface uppercase tracking-wider">Sesi Login Aktif</span>

    @forelse ($activeSessions as $session)
        <div class="bg-surface-container-low rounded-st-xl p-space-md flex items-center justify-between gap-space-sm">
            <div class="flex items-center gap-space-sm min-w-0">
                <span class="material-symbols-outlined {{ $session['is_current'] ? 'text-emerald-600' : 'text-secondary' }} text-headline-sm">{{ $session['device']['mobile'] ? 'smartphone' : 'laptop_mac' }}</span>
                <div class="flex flex-col min-w-0">
                    <span class="font-label-md text-label-md font-semibold text-on-surface truncate">{{ $session['device']['label'] }}{{ $session['is_current'] ? ' (Sesi Ini)' : '' }}</span>
                    <span class="font-body-xs text-body-xs text-secondary">IP: {{ $session['ip'] ?: '-' }} • Aktif {{ $session['last_active'] }}</span>
                </div>
            </div>

            @if ($session['is_current'])
                <span class="bg-emerald-50 text-emerald-800 font-label-sm text-label-sm px-2.5 py-1 rounded-full font-semibold shrink-0">Sedang Aktif</span>
            @else
                <form method="POST" action="{{ route('profile.sessions.destroy', $session['id']) }}" class="shrink-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-error hover:bg-red-50 p-1.5 rounded-st font-label-sm text-label-sm font-semibold flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-body-sm">logout</span>
                        Putus Sesi
                    </button>
                </form>
            @endif
        </div>
    @empty
        <div class="bg-surface-container-low rounded-st-xl p-space-md font-body-sm text-body-sm text-secondary">Belum ada sesi login yang tercatat.</div>
    @endforelse
</div>
