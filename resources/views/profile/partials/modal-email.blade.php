<div x-show="emailModal" x-cloak @click.self="emailModal = false" id="emailModal"
     class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="emailModalTitle">
    <div class="bg-surface-container-lowest rounded-st-xl max-w-md w-full p-space-lg shadow-2xl flex flex-col gap-space-md animate-modal-enter">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs">
                <div class="w-8 h-8 rounded-full bg-red-100 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-body-lg">mark_email_unread</span>
                </div>
                <h4 id="emailModalTitle" class="font-headline-sm text-headline-sm font-bold text-on-surface">Ubah Email Kedinasan</h4>
            </div>
            <button type="button" @click="emailModal = false" aria-label="Tutup"
                    class="text-secondary hover:text-on-surface p-1 rounded-st cursor-pointer">
                <span class="material-symbols-outlined text-body-md">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-space-md">
            @csrf
            @method('PATCH')

            <p class="font-body-sm text-body-sm text-secondary">
                Masukkan alamat email kedinasan baru Anda. Setelah disimpan, email baru perlu diverifikasi ulang.
            </p>

            <div class="flex flex-col gap-space-xs">
                <label for="modalNewEmail" class="font-label-md text-label-md font-semibold text-on-surface">Email Baru (@@telkomakses.co.id)</label>
                <input id="modalNewEmail" name="email" type="email" required autocomplete="email"
                       value="{{ old('email') }}" placeholder="nama.anda@telkomakses.co.id"
                       class="w-full h-11 bg-surface-container-low rounded-st-lg px-space-md font-body-md text-body-md text-on-surface outline-none focus:bg-surface-container border-0 focus:ring-0">
                @error('email')
                    <p class="font-body-xs text-body-xs text-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-amber-50 p-space-sm rounded-st-lg flex items-start gap-2 text-amber-900">
                <span class="material-symbols-outlined text-body-md mt-0.5 text-amber-700">security_update_warning</span>
                <span class="font-body-xs text-body-xs">Status email akan menjadi belum terverifikasi sampai Anda memverifikasinya kembali.</span>
            </div>

            <div class="grid grid-cols-2 gap-2.5 sm:gap-3 w-full sm:w-auto sm:flex sm:items-center sm:justify-end pt-3 border-t border-slate-100">
                <button type="button" @click="emailModal = false"
                        class="h-11 sm:h-10 px-4 rounded-xl bg-slate-100 hover:bg-slate-200/80 active:bg-slate-200 border border-slate-200/90 text-slate-700 hover:text-slate-900 font-headline font-semibold text-xs sm:text-sm transition-all flex items-center justify-center cursor-pointer select-none">
                    Batal
                </button>
                <button type="submit"
                        class="h-11 sm:h-10 px-4 rounded-xl bg-[#AE0C00] hover:bg-[#8E0A00] text-white font-headline font-bold text-xs sm:text-sm transition-all shadow-2xs hover:shadow-xs active:scale-[0.98] flex items-center justify-center gap-1.5 cursor-pointer select-none">
                    <span>Simpan</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>
