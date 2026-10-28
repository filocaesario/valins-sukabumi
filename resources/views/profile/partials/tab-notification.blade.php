@php
    $prefs = $user->notificationPreferences();
    $notificationItems = [
        [
            'name' => 'alert_redaman',
            'icon' => 'warning',
            'iconClass' => 'bg-amber-100 text-amber-800',
            'title' => 'Alert Anomali Redaman GPON (> -24 dBm)',
            'badge' => 'Kritis',
            'description' => 'Tandai akun ini untuk peringatan saat redaman splitter ODP melampaui toleransi standar optik.',
        ],
        [
            'name' => 'dispatch_bot',
            'icon' => 'send',
            'iconClass' => 'bg-sky-100 text-sky-800',
            'title' => 'Notifikasi Tiket Dispatch via Telegram & WA Bot',
            'badge' => null,
            'description' => 'Teruskan pembaruan tiket validasi VALINS baru ke kanal bot operasional Datel Sukabumi.',
        ],
        [
            'name' => 'weekly_audit',
            'icon' => 'analytics',
            'iconClass' => 'bg-surface-container-highest text-tertiary',
            'title' => 'Laporan Rekapitulasi Audit Mingguan',
            'badge' => null,
            'description' => 'Terima ringkasan rekonsiliasi data ODP yang telah divalidasi setiap awal pekan.',
        ],
    ];
@endphp

<div class="flex items-center justify-between border-b pb-space-sm border-transparent">
    <div class="flex flex-col">
        <h3 class="font-headline-md text-headline-md text-on-surface">Preferensi Notifikasi &amp; Alert Lapangan</h3>
        <p class="font-body-sm text-body-sm text-secondary">Atur jenis informasi kritis yang ingin Anda terima sebagai pengguna VALINS.</p>
    </div>
    <span class="material-symbols-outlined text-tertiary text-headline-md">notifications_active</span>
</div>

<form id="notificationForm" method="POST" action="{{ route('profile.notifications.update') }}" class="flex flex-col gap-space-md">
    @csrf
    @method('PATCH')

    @foreach ($notificationItems as $item)
        <div class="bg-surface-container-low p-space-md rounded-st-xl flex items-start justify-between gap-space-md">
            <div class="flex items-start gap-space-sm">
                <div class="w-10 h-10 rounded-st-lg {{ $item['iconClass'] }} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">{{ $item['icon'] }}</span>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="font-label-lg text-label-lg font-bold text-on-surface">{{ $item['title'] }}</span>
                        @if ($item['badge'])
                            <span class="bg-amber-100 text-amber-900 font-label-sm text-label-sm px-2 py-0.5 rounded-st font-semibold">{{ $item['badge'] }}</span>
                        @endif
                    </div>
                    <p class="font-body-xs text-body-xs text-secondary mt-1">{{ $item['description'] }}</p>
                </div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                <input type="checkbox" name="{{ $item['name'] }}" value="1" class="sr-only peer" aria-label="{{ $item['title'] }}" @checked($prefs[$item['name']] ?? false)>
                <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-container"></div>
            </label>
        </div>
    @endforeach

    <div class="flex justify-end pt-4 border-t border-slate-200/80 mt-2">
        <button type="submit"
                class="inline-flex items-center justify-center gap-1.5 sm:gap-2 h-11 sm:h-10 px-4 sm:px-5 text-xs sm:text-sm font-headline font-bold text-white bg-[#AE0C00] hover:bg-[#8E0A00] rounded-xl active:scale-[0.98] transition-all duration-150 shadow-2xs hover:shadow-xs cursor-pointer select-none w-full sm:w-auto whitespace-nowrap">
            <span class="material-symbols-outlined text-[18px] sm:text-[20px] text-white shrink-0">check</span>
            <span class="sm:hidden">Simpan Notifikasi</span>
            <span class="hidden sm:inline">Simpan Pengaturan Notifikasi</span>
        </button>
    </div>
</form>
