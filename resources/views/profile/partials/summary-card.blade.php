{{-- Kartu ringkasan pengguna (kolom kiri). Variabel dari edit.blade.php: $user, $homebases, $isVerified, $initials --}}
@php
    $homebaseTitle = $user->homebase ? ($homebases[$user->homebase] ?? $user->homebase) : null;
    $stoList = collect($user->sto ?? [])->filter()->implode(', ');
    $positionLabel = $user->divisi ?: ($user->emp_type ?: 'Pengguna Valins Sukabumi');
    $serviceStartDate = $user->serviceStartDate();
    $serviceDuration = $user->serviceDurationText();
    $mfaLabels = ['email' => 'Email', 'telegram' => 'Telegram', 'whatsapp' => 'WhatsApp', 'wa' => 'WhatsApp', 'totp' => 'Authenticator'];
    $mfaLabel = $user->mfa_method ? ($mfaLabels[strtolower($user->mfa_method)] ?? $user->mfa_method) : null;
@endphp

<div class="bg-surface-container-lowest rounded-st-xl p-space-lg shadow-sm flex flex-col items-center text-center relative overflow-hidden"
     x-data="{
         currentAvatarUrl: @js($user->avatarUrl()),
         initials: @js($initials),
         isUploading: false,
         hasAvatar: @js((bool) $user->avatar_path),
         showDeleteModal: false,

         notify(msg) {
             if (window.showProfileToast) {
                 window.showProfileToast(msg);
             }
         },
         
         async uploadPhoto(e) {
             const file = e.target.files[0];
             if (!file) return;
             
             if (file.size > 2 * 1024 * 1024) {
                 this.notify('Ukuran foto maksimal 2 MB.');
                 e.target.value = '';
                 return;
             }

             // Simpan riwayat URL & status sebelumnya untuk rollback jika simpan server gagal
             const previousAvatarUrl = this.currentAvatarUrl;
             const previousHasAvatar = this.hasAvatar;

             // 1. INSTANT 0-DETIK CLIENT-SIDE PREVIEW (OPTIMISTIC UI TANPA JEDA JARINGAN)
             let previewUrl = null;
             if (window.URL && window.URL.createObjectURL) {
                 try {
                     previewUrl = URL.createObjectURL(file);
                 } catch (err) {
                     console.warn('URL.createObjectURL error, fallback to FileReader', err);
                 }
             }

             // Terapkan seketika ke wadah kartu profil formulir
             if (previewUrl) {
                 this.currentAvatarUrl = previewUrl;
                 this.hasAvatar = true;

                 // Pancarkan sinyal global klien ke bilah samping (sidebar) dan bilah navigasi atas (header) DETIK ITU JUGA
                 window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                     detail: { avatarUrl: previewUrl } 
                 }));
             }

             // Jalankan FileReader sebagai representasi data lokal di memori peramban
             const reader = new FileReader();
             reader.onload = (event) => {
                 const dataUrl = event.target.result;
                 this.currentAvatarUrl = dataUrl;
                 this.hasAvatar = true;
                 window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                     detail: { avatarUrl: dataUrl } 
                 }));
             };
             reader.readAsDataURL(file);
             
             this.isUploading = true;
             const formData = new FormData();
             formData.append('avatar', file);
             formData.append('_token', '{{ csrf_token() }}');
             
             try {
                 const res = await fetch('{{ route('profile.avatar.update') }}', {
                     method: 'POST',
                     headers: {
                         'Accept': 'application/json',
                         'X-Requested-With': 'XMLHttpRequest'
                     },
                     body: formData
                 });
                 const data = await res.json();
                 if (res.ok && data.status === 'success') {
                     // Berikan penanda versi waktu (cache-busting timestamp) agar peramban selalu mengambil foto terbaru
                     const finalAvatarUrl = data.avatar_url + (data.avatar_url.includes('?') ? '&' : '?') + 't=' + Date.now();
                     this.currentAvatarUrl = finalAvatarUrl;
                     this.hasAvatar = true;
                     window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                         detail: { avatarUrl: finalAvatarUrl } 
                     }));
                     if (window.Livewire) {
                         window.Livewire.dispatch('avatar-updated', { avatarUrl: finalAvatarUrl });
                     }
                     this.notify(data.message || 'Foto profil berhasil diperbarui.');
                 } else {
                     // Rollback tenang ke foto sebelumnya jika server gagal
                     this.currentAvatarUrl = previousAvatarUrl;
                     this.hasAvatar = previousHasAvatar;
                     window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                         detail: { avatarUrl: previousAvatarUrl } 
                     }));
                     if (window.Livewire) {
                         window.Livewire.dispatch('avatar-updated', { avatarUrl: previousAvatarUrl });
                     }
                     this.notify(data.message || 'Gagal mengunggah foto profil.');
                 }
             } catch (err) {
                 console.error(err);
                 // Rollback ke foto sebelumnya jika terjadi kendala jaringan
                 this.currentAvatarUrl = previousAvatarUrl;
                 this.hasAvatar = previousHasAvatar;
                 window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                     detail: { avatarUrl: previousAvatarUrl } 
                 }));
                 if (window.Livewire) {
                     window.Livewire.dispatch('avatar-updated', { avatarUrl: previousAvatarUrl });
                 }
                 this.notify('Terjadi kendala jaringan saat mengunggah foto profil.');
             } finally {
                 this.isUploading = false;
                 e.target.value = '';
                 if (previewUrl && window.URL && window.URL.revokeObjectURL) {
                     setTimeout(() => URL.revokeObjectURL(previewUrl), 10000);
                 }
             }
         },
         
         confirmDeleteAvatar() {
             if (!this.hasAvatar || this.isUploading) return;
             this.showDeleteModal = true;
         },

         closeDeleteModal() {
             this.showDeleteModal = false;
         },

         async executeDeletePhoto() {
             if (!this.hasAvatar || this.isUploading) return;
             
             // 1. Tutup modal konfirmasi seketika
             this.showDeleteModal = false;

             // 2. Simpan URL avatar untuk fallback pemulihan jika transmisi gagal
             const previousAvatarUrl = this.currentAvatarUrl;

             // 3. Langsung kembalikan avatar pengguna menjadi inisial nama secara optimistik
             this.currentAvatarUrl = null;
             this.hasAvatar = false;
             window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                 detail: { avatarUrl: null } 
             }));
             if (window.Livewire) {
                 window.Livewire.dispatch('avatar-updated', { avatarUrl: null });
             }

             // 4. Lencana notifikasi sukses melayang (toast)
             this.notify('Foto profil berhasil dihapus dan dikembalikan ke inisial nama.');

             this.isUploading = true;
             try {
                 const res = await fetch('{{ route('profile.avatar.destroy') }}', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'Accept': 'application/json',
                         'X-Requested-With': 'XMLHttpRequest',
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     },
                     body: JSON.stringify({ _method: 'DELETE' })
                 });
                 const data = await res.json();
                 if (!res.ok || data.status !== 'success') {
                     // Pulihkan tampilan jika server gagal memproses
                     this.currentAvatarUrl = previousAvatarUrl;
                     this.hasAvatar = true;
                     window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                         detail: { avatarUrl: previousAvatarUrl } 
                     }));
                     if (window.Livewire) {
                         window.Livewire.dispatch('avatar-updated', { avatarUrl: previousAvatarUrl });
                     }
                     this.notify(data.message || 'Gagal menghapus foto profil.');
                 }
             } catch (err) {
                 console.error(err);
                 this.currentAvatarUrl = previousAvatarUrl;
                 this.hasAvatar = true;
                 window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                     detail: { avatarUrl: previousAvatarUrl } 
                 }));
                 if (window.Livewire) {
                     window.Livewire.dispatch('avatar-updated', { avatarUrl: previousAvatarUrl });
                 }
                 this.notify('Terjadi kendala saat menghubungi server.');
             } finally {
                 this.isUploading = false;
             }
         }
     }">
    <div class="absolute top-0 left-0 right-0 h-24 bg-[#AE0C00]"></div>

    {{-- Foto profil --}}
    <div class="relative mt-8 mb-space-md group">
        <div class="w-32 h-32 rounded-full overflow-hidden shadow-lg ring-4 ring-surface-container-lowest bg-[#AE0C00] flex items-center justify-center relative">
            @if($user->avatarUrl())
                <img src="{{ $user->avatarUrl() }}" alt="Foto Profil {{ $user->name }}" id="avatarPreview"
                     x-show="currentAvatarUrl"
                     :src="currentAvatarUrl || '{{ $user->avatarUrl() }}'"
                     x-on:error="currentAvatarUrl = null; hasAvatar = false"
                     class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300 absolute inset-0">
            @else
                <template x-if="currentAvatarUrl">
                    <img :src="currentAvatarUrl" alt="Foto Profil {{ $user->name }}" id="avatarPreview"
                         x-on:error="currentAvatarUrl = null; hasAvatar = false"
                         class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300 absolute inset-0">
                </template>
            @endif
            <span x-show="!currentAvatarUrl" class="font-headline text-3xl font-black text-white select-none" style="{{ $user->avatarUrl() ? 'display: none;' : '' }}" aria-hidden="true" x-text="initials">
                {{ $initials }}
            </span>
            <div x-show="isUploading" x-cloak class="absolute inset-0 bg-black/40 flex items-center justify-center text-white backdrop-blur-2xs transition-opacity duration-200">
                <svg class="w-7 h-7 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
            </div>
        </div>
        @if ($isVerified)
            <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-emerald-500 ring-2 ring-surface-container-lowest flex items-center justify-center text-white" title="Akun Aktif &amp; Terverifikasi">
                <span class="material-symbols-outlined text-[14px]">verified</span>
            </div>
        @endif
    </div>

    <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight" id="dispFullname">{{ $user->name }}</h2>
    <p class="font-body-sm text-body-sm text-secondary mb-space-xs">{{ $positionLabel }}</p>

    @if ($user->nik)
        <div class="inline-flex items-center gap-1.5 bg-surface-container-low px-space-md py-1 rounded-full text-tertiary font-telemetry-data text-telemetry-data font-semibold mb-space-md">
            <span class="material-symbols-outlined text-body-sm">badge</span>
            <span>NIK: {{ $user->nik }}</span>
        </div>
    @else
        <div class="mb-space-md"></div>
    @endif

    {{-- Aksi foto --}}
    <div class="flex items-center gap-space-xs w-full mb-space-lg">
        <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" x-ref="avatarForm" class="flex-1 flex">
            @csrf
            <label class="flex-1 cursor-pointer bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-label-md py-2 px-3 rounded-st-lg flex items-center justify-center gap-1.5 transition-colors"
                   :class="isUploading ? 'opacity-60 pointer-events-none' : ''">
                <span class="material-symbols-outlined text-body-md text-secondary">photo_camera</span>
                <span x-text="isUploading ? 'Mengunggah...' : 'Unggah Baru'">Unggah Baru</span>
                <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="hidden"
                       @change="uploadPhoto($event)">
            </label>
        </form>
        <button type="button" title="Hapus Foto" aria-label="Hapus foto profil" 
                @click="confirmDeleteAvatar()"
                :disabled="!hasAvatar || isUploading"
                class="p-2 rounded-st-lg bg-surface-container-low hover:bg-red-50 text-secondary hover:text-error transition-colors cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-surface-container-low disabled:hover:text-secondary">
            <span class="material-symbols-outlined text-body-md">delete</span>
        </button>
    </div>

    {{-- Metadata organisasi --}}
    <div class="w-full bg-surface-container-low rounded-st-xl p-space-md flex flex-col gap-space-sm text-left">
        {{-- Penempatan Teritorial --}}
        <div class="flex items-start gap-space-sm">
            <div class="w-9 h-9 rounded-st-lg bg-red-50 text-primary flex items-center justify-center shrink-0 mt-0.5 border border-red-100/60 shadow-2xs">
                <span class="material-symbols-outlined text-[20px]">apartment</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-label-sm text-label-sm text-secondary uppercase font-semibold tracking-wide">Penempatan Teritorial</span>
                <span class="font-label-md text-label-md font-bold text-on-surface leading-snug truncate">{{ $homebaseTitle ?: 'Belum diatur' }}</span>
                <span class="font-body-xs text-body-xs text-secondary mt-0.5">
                    @if ($stoList)
                        STO {{ $stoList }}@if ($user->regu) • {{ $user->regu }}@endif
                    @elseif ($user->regu)
                        {{ $user->regu }}
                    @else
                        Datel Sukabumi
                    @endif
                </span>
            </div>
        </div>

        {{-- Masa Kedinasan --}}
        <div class="flex items-start gap-space-sm pt-space-xs border-t border-surface-container/60">
            <div class="w-9 h-9 rounded-st-lg bg-red-50 text-primary flex items-center justify-center shrink-0 mt-0.5 border border-red-100/60 shadow-2xs">
                <span class="material-symbols-outlined text-[20px]">calendar_month</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-label-sm text-label-sm text-secondary uppercase font-semibold tracking-wide">Masa Kedinasan</span>
                <span class="font-label-md text-label-md font-bold text-on-surface leading-snug">{{ $serviceStartDate->translatedFormat('j F Y') }}</span>
                <span class="font-body-xs text-body-xs text-secondary mt-0.5">{{ $serviceDuration }}</span>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Kustom Hapus Foto Profil (Eliminasi Dialog Browser Native) --}}
    <template x-teleport="body">
        <div x-show="showDeleteModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             role="dialog"
             aria-modal="true"
             aria-labelledby="modalDeleteAvatarTitle"
             @keydown.escape.window="closeDeleteModal()">
            
            {{-- Smooth Backdrop Blur Overlay (Tirai Redup Halus Abu-abu Gelap Transparan) --}}
            <div x-show="showDeleteModal"
                 x-transition:enter="transition-opacity ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeDeleteModal()"
                 class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"></div>

            {{-- Centered Dialog Container (Center-aligned vertikal & horizontal, Zero Layout Shift) --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                {{-- Modal Box Container: Maks 420px desktop, margin 16px ponsel, squircle rounded-2xl sm:rounded-3xl --}}
                <div x-show="showDeleteModal"
                     x-transition:enter="transition ease-out duration-200 transform-gpu"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150 transform-gpu"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                     @click.stop
                     class="relative w-full max-w-[420px] bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-7 shadow-2xl border border-slate-200/90 text-center flex flex-col items-center will-change-transform">
                    
                    {{-- Tombol Silang Kecil Penutup (Sudut Kanan Atas) --}}
                    <button type="button" 
                            @click="closeDeleteModal()" 
                            aria-label="Tutup modal"
                            class="absolute top-4 right-4 w-8 h-8 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer focus:outline-none">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>

                    {{-- Header & Ikon Peringatan Mikro: Lingkaran Merah Muda Lembut & Ikon Tempat Sampah Merah Telkom Akses --}}
                    <div class="w-14 h-14 rounded-full bg-red-50 border border-red-100 flex items-center justify-center mb-4 text-[#AE0C00] shadow-2xs shrink-0">
                        <span class="material-symbols-outlined text-[28px] text-[#AE0C00]" style="font-variation-settings: 'FILL' 0;">delete_outline</span>
                    </div>

                    {{-- Teks Judul Modal & Keterangan Sub-Deskripsi --}}
                    <h3 id="modalDeleteAvatarTitle" class="font-headline font-bold text-lg sm:text-xl text-slate-800 tracking-tight mb-2">
                        Hapus Foto Profil?
                    </h3>
                    <p class="font-body text-xs sm:text-sm text-slate-500 leading-relaxed max-w-sm mb-6">
                        Foto profil Anda saat ini akan dihapus dan avatar akun akan dikembalikan ke tampilan standar dengan inisial nama. Tindakan ini dapat diubah kapan saja.
                    </p>

                    {{-- Penataan Pasangan Tombol Aksi (Bersisian Horizontal / Bertumpuk Responsif) --}}
                    <div class="grid grid-cols-2 gap-3 w-full">
                        {{-- Tombol Sekunder Batal (Sisi Kiri) --}}
                        <button type="button" 
                                @click="closeDeleteModal()"
                                class="w-full h-11 px-4 rounded-xl bg-white hover:bg-slate-50 active:bg-slate-100 border border-slate-200/90 text-slate-700 hover:text-slate-900 font-headline font-semibold text-sm transition-all flex items-center justify-center cursor-pointer select-none">
                            Batal
                        </button>

                        {{-- Tombol Utama Destruktif Hapus Foto (Sisi Kanan) --}}
                        <button type="button" 
                                @click="executeDeletePhoto()"
                                class="w-full h-11 px-4 rounded-xl bg-[#AE0C00] hover:bg-[#8E0A00] active:scale-[0.98] text-white font-headline font-bold text-sm transition-all shadow-sm hover:shadow flex items-center justify-center gap-1.5 cursor-pointer select-none">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            <span>Hapus Foto</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

{{-- Ringkasan keamanan --}}
<div class="bg-surface-container-lowest rounded-st-xl p-space-md shadow-sm flex items-center justify-between">
    <div class="flex items-center gap-space-sm">
        <div class="w-10 h-10 rounded-st-lg bg-surface-container-low text-tertiary flex items-center justify-center">
            <span class="material-symbols-outlined">security</span>
        </div>
        <div class="flex flex-col">
            <span class="font-label-md text-label-md font-bold text-on-surface">2-Factor Auth (2FA)</span>
            @if ($mfaLabel)
                <span class="font-body-xs text-body-xs text-emerald-600 font-medium">Aktif • {{ $mfaLabel }}</span>
            @else
                <span class="font-body-xs text-body-xs text-secondary font-medium">Belum diaktifkan</span>
            @endif
        </div>
    </div>
    <button type="button" @click="tab = 'security'"
            class="text-tertiary hover:text-on-tertiary-fixed-variant font-label-md text-label-md font-semibold px-2 py-1 rounded-st hover:bg-surface-container cursor-pointer">
        Kelola
    </button>
</div>
