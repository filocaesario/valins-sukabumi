<x-app-layout>
    @php
        $errors = $errors ?? new \Illuminate\Support\ViewErrorBag();
        $isVerified = ! is_null($user->email_verified_at);
        $passwordHasErrors = $errors->getBag('updatePassword')->isNotEmpty();
        $emailHasErrors = $errors->has('email');
        $openTab = $passwordHasErrors ? 'security' : 'profile';

        $nameParts = preg_split('/\s+/', trim(\Illuminate\Support\Str::before($user->name, ',')), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $initials = \Illuminate\Support\Str::upper(collect($nameParts)->take(2)->map(fn ($part) => \Illuminate\Support\Str::substr($part, 0, 1))->implode('')) ?: 'U';

        $statusMessages = [
            'profile-updated' => 'Perubahan profil Anda berhasil disimpan.',
            'avatar-updated' => 'Foto profil berhasil diperbarui.',
            'avatar-removed' => 'Foto profil berhasil dihapus.',
            'notifications-updated' => 'Preferensi notifikasi berhasil disimpan.',
            'password-updated' => 'Kata sandi akun berhasil diperbarui.',
            'session-revoked' => 'Sesi login berhasil diputus.',
        ];
        $toastMessage = $statusMessages[session('status')] ?? null;
    @endphp

    <div class="bg-background min-h-[calc(100vh-4rem)] px-space-lg py-space-lg"
         x-data="{
             tab: @js($openTab),
             emailModal: @js($emailHasErrors),
             passwordModal: @js($passwordHasErrors),
             toastOpen: @js((bool) $toastMessage),
             toastText: @js($toastMessage ?? ''),
             init() {
                 if (this.toastOpen) { setTimeout(() => this.toastOpen = false, 4500); }
                 window.showProfileToast = (msg) => {
                     this.toastText = msg;
                     this.toastOpen = true;
                     setTimeout(() => this.toastOpen = false, 4500);
                 };
                 @if (session('status') === 'avatar-updated' || session('status') === 'avatar-removed')
                     window.dispatchEvent(new CustomEvent('profile-avatar-updated', { 
                         detail: { avatarUrl: @js($user->avatarUrl()) } 
                     }));
                 @endif
             },
             saveActive() {
                 const formId = { profile: 'profileForm', notification: 'notificationForm' }[this.tab];
                 if (formId) { document.getElementById(formId).requestSubmit(); }
             }
         }"
         @keydown.escape.window="emailModal = false; passwordModal = false">
        <div class="flex flex-col w-full">

            {{-- Toast notifikasi --}}
            <div x-show="toastOpen" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-5"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-5"
                 role="status" aria-live="polite" id="toastNotification"
                 class="fixed top-20 right-8 z-50 flex items-center gap-space-sm bg-surface-container-lowest text-on-surface p-space-md rounded-st-xl shadow-xl">
                <div class="w-8 h-8 rounded-full bg-emerald-500/15 flex items-center justify-center text-emerald-600 shrink-0">
                    <span class="material-symbols-outlined text-headline-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                </div>
                <div class="flex flex-col pr-space-md">
                    <span class="font-label-lg text-label-lg font-bold text-on-surface">Perubahan Disimpan</span>
                    <span class="font-body-xs text-body-xs text-secondary" x-text="toastText">{{ $toastMessage }}</span>
                </div>
                <button type="button" @click="toastOpen = false" aria-label="Tutup notifikasi"
                        class="text-secondary hover:text-on-surface p-space-xs rounded-st transition-colors">
                    <span class="material-symbols-outlined text-body-md">close</span>
                </button>
            </div>

            @if ($errors->has('avatar') || $errors->has('sessionId'))
                <div class="mb-space-md flex items-start gap-space-sm bg-error-container text-on-error-container p-space-md rounded-st-xl" role="alert">
                    <span class="material-symbols-outlined text-body-lg shrink-0">error</span>
                    <div class="font-body-sm text-body-sm">
                        @foreach (array_merge($errors->get('avatar'), $errors->get('sessionId')) as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Header halaman --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-md mb-space-lg">
                <div class="flex flex-col">
                    <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">Pengaturan Akun &amp; Profil Pengguna</h1>
                    <p class="font-body-md text-body-md text-secondary mt-1">Kelola identitas diri, nama panggilan (nickname), alamat email kedinasan, dan preferensi notifikasi lapangan.</p>
                </div>
                <div class="flex items-center gap-space-sm">
                    <button type="button" id="btnSaveHeader" x-show="tab !== 'security'" @click="saveActive()"
                            class="bg-primary-container hover:bg-primary text-on-primary font-label-lg text-label-lg px-space-lg py-space-sm rounded-st-lg flex items-center gap-space-xs shadow-md transition-all active:scale-95 cursor-pointer">
                        <span class="material-symbols-outlined text-body-lg">sync_saved_locally</span>
                        <span>Simpan</span>
                    </button>
                </div>
            </div>

            {{-- Workspace 2 kolom --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">

                {{-- Kolom kiri: ringkasan pengguna --}}
                <div class="lg:col-span-4 flex flex-col gap-space-md">
                    @include('profile.partials.summary-card')
                </div>

                {{-- Kolom kanan: panel pengaturan --}}
                <div class="lg:col-span-8 flex flex-col gap-space-md">
                    <div class="bg-surface-container-lowest rounded-st-xl p-1.5 shadow-sm flex flex-wrap gap-1.5" role="tablist">
                        @foreach ([
                            ['key' => 'profile', 'icon' => 'person_pin', 'label' => 'Informasi Profil & Identitas'],
                            ['key' => 'security', 'icon' => 'lock_reset', 'label' => 'Keamanan & Autentikasi'],
                            ['key' => 'notification', 'icon' => 'notifications_active', 'label' => 'Preferensi Notifikasi'],
                        ] as $tabItem)
                            <button type="button" role="tab" id="tabBtn{{ \Illuminate\Support\Str::studly($tabItem['key']) }}"
                                    @click="tab = '{{ $tabItem['key'] }}'"
                                    :aria-selected="tab === '{{ $tabItem['key'] }}'"
                                    :class="tab === '{{ $tabItem['key'] }}'
                                        ? 'bg-primary-container text-on-primary-container shadow-sm font-semibold'
                                        : 'text-secondary hover:bg-surface-container hover:text-on-surface'"
                                    class="flex-1 min-w-[160px] py-space-sm px-space-md rounded-st-lg font-label-lg text-label-lg transition-all flex items-center justify-center gap-space-xs cursor-pointer">
                                <span class="material-symbols-outlined text-body-lg">{{ $tabItem['icon'] }}</span>
                                <span>{{ $tabItem['label'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <div x-show="tab === 'profile'" id="tabContentProfile" role="tabpanel"
                         class="bg-surface-container-lowest rounded-st-xl p-space-lg shadow-sm flex flex-col gap-space-lg">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div x-show="tab === 'security'" x-cloak id="tabContentSecurity" role="tabpanel"
                         class="bg-surface-container-lowest rounded-st-xl p-space-lg shadow-sm flex flex-col gap-space-lg">
                        @include('profile.partials.tab-security')
                    </div>

                    <div x-show="tab === 'notification'" x-cloak id="tabContentNotification" role="tabpanel"
                         class="bg-surface-container-lowest rounded-st-xl p-space-lg shadow-sm flex flex-col gap-space-lg">
                        @include('profile.partials.tab-notification')
                    </div>
                </div>
            </div>
        </div>

        @include('profile.partials.modal-email')
        @include('profile.partials.update-password-form')
    </div>
</x-app-layout>
