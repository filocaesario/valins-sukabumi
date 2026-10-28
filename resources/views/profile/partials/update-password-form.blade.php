@php
    $passwordFields = [
        ['id' => 'current_password', 'label' => 'Kata Sandi Saat Ini', 'autocomplete' => 'current-password'],
        ['id' => 'password', 'label' => 'Kata Sandi Baru', 'autocomplete' => 'new-password'],
        ['id' => 'password_confirmation', 'label' => 'Konfirmasi Kata Sandi Baru', 'autocomplete' => 'new-password'],
    ];
@endphp

<div x-show="passwordModal" x-cloak @click.self="passwordModal = false" id="passwordModal"
     class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="passwordModalTitle">
    <div class="bg-surface-container-lowest rounded-st-xl max-w-md w-full p-space-lg shadow-2xl flex flex-col gap-space-md animate-modal-enter">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-space-xs">
                <div class="w-8 h-8 rounded-full bg-red-100 text-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-body-lg">lock_reset</span>
                </div>
                <h4 id="passwordModalTitle" class="font-headline-sm text-headline-sm font-bold text-on-surface">Ubah Kata Sandi</h4>
            </div>
            <button type="button" @click="passwordModal = false" aria-label="Tutup"
                    class="text-secondary hover:text-on-surface p-1 rounded-st cursor-pointer transition-transform duration-200 hover:rotate-90 flex items-center justify-center">
                <span class="material-symbols-outlined text-body-md">close</span>
            </button>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-space-md">
            @csrf
            @method('PUT')

            @foreach ($passwordFields as $field)
                @php
                    $hasFieldError = isset($errors) && $errors->getBag('updatePassword')->has($field['id']);
                @endphp
                <div class="flex flex-col gap-space-xs">
                    <label for="modal_{{ $field['id'] }}" class="font-label-md text-label-md font-semibold text-on-surface">
                        {{ $field['label'] }}
                    </label>
                    <div class="relative flex items-center" x-data="{ show: false }">
                        <span class="material-symbols-outlined absolute left-3.5 text-slate-400 text-[19px] pointer-events-none select-none transition-colors duration-200">
                            lock
                        </span>
                        <input :type="show ? 'text' : 'password'"
                               type="password"
                               id="modal_{{ $field['id'] }}"
                               name="{{ $field['id'] }}"
                               required
                               autocomplete="{{ $field['autocomplete'] }}"
                               class="w-full h-11 bg-white text-on-surface rounded-st-lg pl-10 pr-10 font-body-md text-body-md border {{ $hasFieldError ? 'border-error' : 'border-slate-200' }} focus:border-[#bc0007] focus:ring-1 focus:ring-[#bc0007]/20 focus:outline-none transition-colors duration-200">
                        <button type="button"
                                @click="show = !show"
                                :title="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                tabindex="-1"
                                class="absolute right-2.5 p-1 rounded-st text-slate-400 hover:text-slate-700 active:text-slate-900 focus:outline-none flex items-center justify-center transition-colors duration-200 cursor-pointer">
                            <span class="material-symbols-outlined text-[20px] select-none" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                        </button>
                    </div>
                    @if (isset($errors))
                        @foreach ($errors->getBag('updatePassword')->get($field['id']) as $message)
                            <p class="font-body-xs text-body-xs text-error font-medium">{{ $message }}</p>
                        @endforeach
                    @endif
                </div>
            @endforeach

            <div class="grid grid-cols-2 gap-2.5 sm:gap-3 w-full sm:w-auto sm:flex sm:items-center sm:justify-end pt-3 border-t border-slate-100">
                <button type="button" @click="passwordModal = false"
                        class="h-11 sm:h-10 px-4 rounded-xl bg-slate-100 hover:bg-slate-200/80 active:bg-slate-200 border border-slate-200/90 text-slate-700 hover:text-slate-900 font-headline font-semibold text-xs sm:text-sm transition-all flex items-center justify-center cursor-pointer select-none">
                    Batal
                </button>
                <button type="submit"
                        class="h-11 sm:h-10 px-4 rounded-xl bg-[#AE0C00] hover:bg-[#8E0A00] text-white font-headline font-bold text-xs sm:text-sm transition-all shadow-2xs hover:shadow-xs active:scale-[0.98] flex items-center justify-center cursor-pointer select-none">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
