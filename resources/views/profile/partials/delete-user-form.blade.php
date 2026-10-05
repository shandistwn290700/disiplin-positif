<section>
    <header class="card-header">
        <span class="icon-tile bg-red-50 text-red-600"><x-icon name="trash" /></span>
        <div>
            <h2 class="section-title">Hapus Akun</h2>
            <p class="section-subtitle">
                Setelah akun dihapus, semua data di dalamnya akan terhapus permanen. Sebelum menghapus, unduh dulu data atau informasi yang ingin kamu simpan.
            </p>
        </div>
    </header>

    <div class="card-body">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >Hapus Akun</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-7">
            @csrf
            @method('delete')

            <div class="flex items-start gap-4">
                <span class="icon-tile bg-red-50 text-red-600"><x-icon name="warning" /></span>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        Yakin ingin menghapus akun ini?
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Setelah akun dihapus, semua data di dalamnya akan terhapus permanen. Masukkan password kamu untuk mengonfirmasi penghapusan akun.
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="Password"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button>
                    Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
