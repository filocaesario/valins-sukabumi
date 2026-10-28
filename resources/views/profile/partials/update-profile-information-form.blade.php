{{-- Tab 1: Informasi Profil & Identitas. Variabel: $user, $homebases, $isVerified --}}
@php
    $nicknameValue = old('nickname', $user->nickname ?: \Illuminate\Support\Str::limit(trim(\Illuminate\Support\Str::before($user->name, ',')), 24, ''));
    $phoneValue = old('wa_phone', $user->wa_phone);
    $homebaseValue = old('homebase', $user->homebase);
    $serviceStartDateValue = old('service_start_date', $user->service_start_date ? \Illuminate\Support\Carbon::parse($user->service_start_date)->format('Y-m-d') : ($user->created_at ? $user->created_at->format('Y-m-d') : ''));
    $updatedAt = $user->updated_at?->copy()->locale('id');
@endphp

<div class="flex items-center justify-between border-b pb-space-sm border-transparent">
    <div class="flex flex-col">
        <h3 class="font-headline-md text-headline-md text-on-surface">Identitas Validator &amp; Pegawai Lapangan</h3>
        <p class="font-body-sm text-body-sm text-secondary">Data identitas akun SIM VALINS Anda. Nama lengkap dikunci, sedangkan nama panggilan, kontak, dan posko dapat diperbarui.</p>
    </div>
    <span class="material-symbols-outlined text-tertiary text-headline-md">badge</span>
</div>

<form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="hidden">@csrf</form>

<form method="POST" action="{{ route('profile.update') }}" id="profileForm" x-ref="profileForm"
      x-data="{ nickLen: {{ mb_strlen($nicknameValue) }} }"
      @reset="$nextTick(() => nickLen = $refs.nickname.value.length)"
      class="flex flex-col gap-space-md">
    @csrf
    @method('PATCH')

    {{-- Nama lengkap (read-only) --}}
    <div class="flex flex-col gap-space-xs">
        <div class="flex items-center justify-between">
            <label for="inputFullName" class="font-label-lg text-label-lg font-semibold text-on-surface">Nama Lengkap Sesuai SK</label>
            <div class="flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-st text-label-sm font-semibold">
                <span class="material-symbols-outlined text-[14px]">verified</span>
                <span>Data Kedinasan (Read-Only)</span>
            </div>
        </div>
        <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-secondary text-body-lg">person</span>
            <input type="text" id="inputFullName" value="{{ $user->name }}" readonly tabindex="-1"
                   class="w-full h-11 bg-surface-container-low text-secondary rounded-st-lg pl-10 pr-10 font-body-md text-body-md cursor-not-allowed outline-none select-none">
            <span class="material-symbols-outlined absolute right-3 text-secondary text-body-md" title="Dikunci oleh Administrator HR">lock</span>
        </div>
        <p class="font-body-xs text-body-xs text-secondary">Perubahan gelar atau penulisan nama resmi memerlukan eskalasi ke HR &amp; Unit Operasi Witel.</p>
    </div>

    {{-- Nickname --}}
    <div class="flex flex-col gap-space-xs">
        <div class="flex items-center justify-between">
            <label for="inputNickname" class="font-label-lg text-label-lg font-semibold text-on-surface flex items-center gap-1">
                <span>Nama Panggilan / Nickname Operasional</span>
            </label>
        </div>
        <div class="relative flex items-center">
            <span class="material-symbols-outlined absolute left-3 text-tertiary text-body-lg">edit_note</span>
            <input type="text" id="inputNickname" name="nickname" x-ref="nickname" value="{{ $nicknameValue }}" maxlength="24" required
                   @input="nickLen = $event.target.value.length"
                   class="w-full h-11 bg-surface-container-lowest text-on-surface rounded-st-lg pl-10 pr-4 font-body-md text-body-md border border-surface-container-highest focus:bg-surface-container-low focus:border-primary-container outline-none transition-all">
        </div>
        @error('nickname')
            <p class="font-body-xs text-body-xs text-error font-medium">{{ $message }}</p>
        @enderror
        <div class="flex items-start gap-1.5 text-secondary bg-surface-container-low p-space-sm rounded-st-lg">
            <span class="material-symbols-outlined text-body-sm text-tertiary mt-0.5">info</span>
            <p class="font-body-xs text-body-xs">Nickname disimpan pada profil akun Anda sebagai nama singkat. Nama resmi pada SK tidak berubah.</p>
        </div>
    </div>

    {{-- Email utama & Tanggal Mulai Kedinasan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
        <div class="flex flex-col gap-space-xs">
            <div class="flex items-center justify-between">
                <label for="inputCorpEmail" class="font-label-lg text-label-lg font-semibold text-on-surface">Email (Utama)</label>
                <span class="bg-blue-50 text-blue-800 font-label-sm text-label-sm px-2 py-0.5 rounded-st font-semibold">Akun Login</span>
            </div>
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-secondary text-body-lg">mail</span>
                <input type="email" id="inputCorpEmail" value="{{ $user->email }}" readonly
                       class="w-full h-11 bg-surface-container-low text-on-surface rounded-st-lg pl-10 pr-24 font-body-md text-body-md outline-none">
                <button type="button" @click="emailModal = true"
                        class="absolute right-1.5 px-space-sm py-1 rounded-st bg-surface-container-highest hover:bg-secondary-container text-on-surface font-label-sm text-label-sm font-semibold transition-colors cursor-pointer">
                    Ubah Email
                </button>
            </div>
            <p class="font-body-xs text-body-xs text-secondary">Digunakan untuk akses login dan penerimaan email sistem.</p>
            @unless ($isVerified)
                <p class="font-body-xs text-body-xs text-amber-700 flex flex-wrap items-center gap-1">
                    <span class="material-symbols-outlined text-body-sm">warning</span>
                    <span>Email belum terverifikasi.</span>
                    <button type="submit" form="send-verification" class="underline font-semibold hover:text-amber-900 cursor-pointer">Kirim ulang tautan verifikasi</button>
                </p>
            @endunless
            @if (session('status') === 'verification-link-sent')
                <p class="font-body-xs text-body-xs text-emerald-700 font-medium">Tautan verifikasi baru telah dikirim ke email Anda.</p>
            @endif
        </div>

        <div class="flex flex-col gap-space-xs">
            <div class="flex items-center justify-between">
                <label for="inputServiceStartDate" class="font-label-lg text-label-lg font-semibold text-on-surface">Tanggal Mulai Kedinasan / Tugas</label>
                <span class="text-secondary bg-surface-container-low px-2 py-0.5 rounded-st font-label-sm text-label-sm font-semibold">Masa Tugas</span>
            </div>
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-primary text-body-lg pointer-events-none">calendar_month</span>
                <input type="date" id="inputServiceStartDate" name="service_start_date"
                       value="{{ $serviceStartDateValue }}"
                       class="w-full h-11 bg-white text-on-surface rounded-st-lg pl-10 pr-4 font-body-md text-body-md border border-surface-container-highest focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition-all cursor-pointer">
            </div>
            @error('service_start_date')
                <p class="font-body-xs text-body-xs text-error font-medium">{{ $message }}</p>
            @enderror
            <p class="font-body-xs text-body-xs text-secondary">Tentukan tanggal awal penugasan atau masa mulai kerja Anda di unit operasional.</p>
        </div>
    </div>

    {{-- Kontak & posko --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
        {{-- Nomor Handphone / WhatsApp (Khusus Angka) --}}
        <div class="flex flex-col gap-space-xs" x-data="{ phone: @js((string) $phoneValue) }">
            <div class="flex items-center justify-between">
                <label for="inputPhone" class="font-label-lg text-label-lg font-semibold text-on-surface">Nomor Handphone / WhatsApp</label>
                <template x-if="phone && phone.trim().length >= 9">
                </template>
                <template x-if="!phone || phone.trim().length < 9">
                    <span class="text-secondary bg-surface-container-low px-2 py-0.5 rounded-st font-label-sm text-label-sm font-semibold">
                        Belum diisi
                    </span>
                </template>
            </div>
            <div class="relative flex items-center">
                <span class="material-symbols-outlined absolute left-3 text-emerald-600 text-body-lg pointer-events-none">phone_android</span>
                <input type="tel"
                       id="inputPhone"
                       name="wa_phone"
                       x-model="phone"
                       inputmode="numeric"
                       pattern="[0-9]*"
                       maxlength="15"
                       autocomplete="tel"
                       placeholder="081234567890"
                       @keydown="if (!/[0-9]/.test($event.key) && !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab', 'Home', 'End'].includes($event.key) && !$event.ctrlKey && !$event.metaKey) { $event.preventDefault(); }"
                       @input="phone = $event.target.value = $event.target.value.replace(/\D/g, '').slice(0, 15)"
                       @paste="setTimeout(() => { phone = $el.value = $el.value.replace(/\D/g, '').slice(0, 15) }, 0)"
                       class="w-full h-11 bg-white text-on-surface rounded-st-lg pl-10 pr-4 font-telemetry-data text-telemetry-data font-semibold tracking-wide border border-surface-container-highest focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary/20 outline-none transition-all">
            </div>
            @error('wa_phone')
                <p class="font-body-xs text-body-xs text-error font-medium">{{ $message }}</p>
            @enderror
            <p class="font-body-xs text-body-xs text-secondary">Kontak utama untuk koordinasi dan dispatch lapangan.</p>
        </div>

        {{-- Sektor Kerja Default (Homebase) Custom Dropup --}}
        <div class="flex flex-col gap-space-xs"
             x-data="{
                 open: false,
                 selected: @js((string) ($homebaseValue ?: '')),
                 selectedLabel: @js($homebaseValue ? ($homebases[$homebaseValue] ?? $homebaseValue) : 'Pilih posko / homebase'),
                 select(value, label) {
                     this.selected = value;
                     this.selectedLabel = label;
                     this.open = false;
                 }
             }"
             @click.away="open = false"
             @keydown.escape.window="open = false">
            <div class="flex items-center justify-between">
                <label id="homebaseLabel" class="font-label-lg text-label-lg font-semibold text-on-surface">Sektor Kerja Default (Homebase)</label>
                <span class="text-secondary bg-surface-container-low px-2 py-0.5 rounded-st font-label-sm text-label-sm font-semibold">Posko Utama</span>
            </div>

            {{-- Hidden input untuk pengiriman form standar --}}
            <input type="hidden" name="homebase" :value="selected">

            {{-- Kotak Jangkar Pemicu & Menu Dropup Melayang --}}
            <div class="relative w-full">
                {{-- Kotak Pilihan Utama (Trigger Box) --}}
                <button type="button"
                        id="selectSectorBtn"
                        @click="open = !open"
                        aria-haspopup="listbox"
                        :aria-expanded="open"
                        aria-labelledby="homebaseLabel"
                        :class="open ? 'border-primary ring-1 ring-primary/20 bg-white' : 'border-surface-container-highest bg-white hover:bg-surface-container-lowest'"
                        class="w-full h-11 rounded-st-lg px-3 border transition-all flex items-center justify-between gap-2 text-left cursor-pointer outline-none">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="material-symbols-outlined text-[20px] text-primary shrink-0">pin_drop</span>
                        <span class="font-body-md text-body-md font-semibold text-on-surface truncate"
                              x-text="selectedLabel"></span>
                    </div>
                    <span class="material-symbols-outlined text-body-lg text-secondary shrink-0 transition-transform duration-200"
                          :class="open ? 'rotate-180 text-primary' : ''">expand_more</span>
                </button>

                {{-- Panel Opsi Melayang ke Atas (Dropup Layer Anti-Dorongan) --}}
                <div x-show="open"
                     x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-98"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-98"
                     role="listbox"
                     style="scrollbar-width: thin; scrollbar-color: rgba(188, 0, 7, 0.25) transparent;"
                     class="absolute z-50 left-0 right-0 bottom-full mb-1.5 bg-white border border-surface-container-high rounded-st-xl shadow-2xl overflow-hidden py-1 max-h-56 overflow-y-auto">
                    @foreach ($homebases as $value => $title)
                        <div role="option"
                             :aria-selected="selected === @js($value)"
                             @click="select(@js($value), @js($title))"
                             :class="selected === @js($value) ? 'bg-red-50/70 font-semibold text-primary' : 'text-on-surface hover:bg-red-50/40'"
                             class="px-3.5 py-2.5 flex items-center justify-between gap-2 cursor-pointer transition-colors text-body-sm">
                            <div class="flex items-center gap-2 min-w-0">
                                <span class="material-symbols-outlined text-[16px] shrink-0"
                                      :class="selected === @js($value) ? 'text-primary' : 'text-secondary/60'">apartment</span>
                                <span class="truncate">{{ $title }}</span>
                            </div>
                            <template x-if="selected === @js($value)">
                                <span class="material-symbols-outlined text-[18px] text-primary shrink-0">check</span>
                            </template>
                        </div>
                    @endforeach
                </div>
            </div>

            @error('homebase')
                <p class="font-body-xs text-body-xs text-error font-medium">{{ $message }}</p>
            @enderror
            <p class="font-body-xs text-body-xs text-secondary">Posko lapangan utama yang tercatat pada profil Anda.</p>
        </div>
    </div>

    {{-- Aksi Formulir --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 pt-4 sm:pt-5 border-t border-slate-200/80 mt-2">
        <div class="hidden sm:flex items-center gap-1.5 text-xs text-slate-500">
            <span class="material-symbols-outlined text-[16px] text-slate-400">info</span>
            <span>Pastikan data yang Anda masukkan telah sesuai sebelum menyimpan.</span>
        </div>

        <div class="grid grid-cols-2 gap-2.5 sm:gap-3 w-full sm:w-auto sm:flex sm:items-center">
            <!-- 1. Tombol Sekunder "Reset Formulir" (Kolom Kiri 50% di Layar Ponsel) -->
            <button type="reset"
                    class="group inline-flex items-center justify-center gap-1.5 sm:gap-2 h-11 sm:h-10 px-2.5 sm:px-4 text-xs sm:text-sm font-headline font-semibold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200/80 active:bg-slate-200 border border-slate-200/90 hover:border-slate-300 rounded-xl active:scale-[0.98] transition-all duration-150 shadow-2xs hover:shadow-xs cursor-pointer select-none w-full sm:w-auto whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px] sm:text-[20px] text-slate-500 group-hover:text-slate-700 shrink-0 transition-transform duration-300 group-hover:-rotate-90">refresh</span>
                <span class="truncate">Reset Formulir</span>
            </button>

            <!-- 2. Tombol Utama "Simpan Profil" (Kolom Kanan 50% di Layar Ponsel) -->
            <button type="submit"
                    class="inline-flex items-center justify-center gap-1.5 sm:gap-2 h-11 sm:h-10 px-2.5 sm:px-5 text-xs sm:text-sm font-headline font-bold text-white bg-[#AE0C00] hover:bg-[#8E0A00] rounded-xl active:scale-[0.98] transition-all duration-150 shadow-2xs hover:shadow-xs cursor-pointer select-none w-full sm:w-auto whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px] sm:text-[20px] text-white shrink-0">check</span>
                <span class="sm:hidden">Simpan Profil</span>
                <span class="hidden sm:inline">Simpan Perubahan Profil</span>
            </button>
        </div>
    </div>
</form>

{{-- ================= KARTU NAVIGASI INFORMASI & KEBIJAKAN (KHUSUS TAMPILAN PONSEL / VIEWPORT 360px - 430px) ================= --}}
<div class="block lg:hidden mt-6 pt-5 border-t border-slate-200/80 pb-16 sm:pb-20">
    <!-- 1. Header Bagian -->
    <div class="mb-2.5 px-0.5">
        <span class="text-[11px] font-headline font-bold text-slate-400 uppercase tracking-widest block">
            INFORMASI &amp; KEBIJAKAN
        </span>
    </div>

    <!-- 2. Struktur Wadah Kartu Utama (List-Group Card) -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden divide-y divide-slate-100">
        <!-- Baris 1: Hubungi Kami -->
        <a href="{{ route('contact.us') }}" 
           class="min-h-[56px] py-3 px-3.5 sm:px-4 flex items-center justify-between gap-3 w-full transition-colors duration-150 bg-white hover:bg-slate-50 active:bg-slate-100/90 text-left group">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 border border-teal-100/70 flex items-center justify-center shrink-0 shadow-2xs">
                    <span class="material-symbols-outlined text-[20px] text-teal-600">headset_mic</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="font-headline font-semibold text-xs sm:text-sm text-slate-800 group-hover:text-slate-900 leading-tight truncate">
                        Hubungi Kami
                    </div>
                    <div class="font-body text-[11px] text-slate-500 leading-snug mt-0.5 truncate">
                        Saluran komunikasi bantuan teknis dan helpdesk operasional.
                    </div>
                </div>
            </div>
            <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-slate-600 group-hover:translate-x-0.5 transition-all shrink-0">
                chevron_right
            </span>
        </a>

        <!-- Baris 2: Tentang Kami -->
        <a href="{{ route('about.us') }}" 
           class="min-h-[56px] py-3 px-3.5 sm:px-4 flex items-center justify-between gap-3 w-full transition-colors duration-150 bg-white hover:bg-slate-50 active:bg-slate-100/90 text-left group">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-700 border border-sky-100/70 flex items-center justify-center shrink-0 shadow-2xs">
                    <span class="material-symbols-outlined text-[20px] text-sky-600">info</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="font-headline font-semibold text-xs sm:text-sm text-slate-800 group-hover:text-slate-900 leading-tight truncate">
                        Tentang Kami
                    </div>
                    <div class="font-body text-[11px] text-slate-500 leading-snug mt-0.5 truncate">
                        Sistem monitoring rekonsiliasi data Telkom Akses Witel Sukabumi.
                    </div>
                </div>
            </div>
            <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-slate-600 group-hover:translate-x-0.5 transition-all shrink-0">
                chevron_right
            </span>
        </a>

        <!-- Baris 3: Kebijakan Privasi -->
        <a href="{{ route('privacy.policy') }}" 
           class="min-h-[56px] py-3 px-3.5 sm:px-4 flex items-center justify-between gap-3 w-full transition-colors duration-150 bg-white hover:bg-slate-50 active:bg-slate-100/90 text-left group">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 border border-slate-200/70 flex items-center justify-center shrink-0 shadow-2xs">
                    <span class="material-symbols-outlined text-[20px] text-slate-600">shield</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="font-headline font-semibold text-xs sm:text-sm text-slate-800 group-hover:text-slate-900 leading-tight truncate">
                        Kebijakan Privasi
                    </div>
                    <div class="font-body text-[11px] text-slate-500 leading-snug mt-0.5 truncate">
                        Perlindungan data akun kedinasan dan kerahasiaan sistem.
                    </div>
                </div>
            </div>
            <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-slate-600 group-hover:translate-x-0.5 transition-all shrink-0">
                chevron_right
            </span>
        </a>

        <!-- Baris 4: Syarat & Ketentuan -->
        <a href="{{ route('terms.conditions') }}" 
           class="min-h-[56px] py-3 px-3.5 sm:px-4 flex items-center justify-between gap-3 w-full transition-colors duration-150 bg-white hover:bg-slate-50 active:bg-slate-100/90 text-left group">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-zinc-100 text-zinc-700 border border-zinc-200/70 flex items-center justify-center shrink-0 shadow-2xs">
                    <span class="material-symbols-outlined text-[20px] text-zinc-600">description</span>
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="font-headline font-semibold text-xs sm:text-sm text-slate-800 group-hover:text-slate-900 leading-tight truncate">
                        Syarat &amp; Ketentuan
                    </div>
                    <div class="font-body text-[11px] text-slate-500 leading-snug mt-0.5 truncate">
                        Pedoman tata tertib validasi data dan hak akses pengguna.
                    </div>
                </div>
            </div>
            <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-slate-600 group-hover:translate-x-0.5 transition-all shrink-0">
                chevron_right
            </span>
        </a>
    </div>
</div>
