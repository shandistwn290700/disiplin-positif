@extends('layouts.main')

@section('content')
    <x-page-header title="Ubah Akun" :subtitle="$user->name" :back="route('users.index')" />

    <div class="max-w-2xl">
        <x-validation-errors />

        <form method="POST" action="{{ route('users.update', $user) }}" class="card">
            @csrf
            @method('PUT')

            <div class="card-body space-y-5">
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control w-full" required>
                    </div>

                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control w-full" required>
                    </div>
                </div>

                <div>
                    <label class="form-label">Password Baru <span class="font-normal text-slate-400">(opsional)</span></label>
                    <input type="password" name="password" id="new-password" class="form-control w-full" minlength="8">
                    <div class="mt-2.5">
                        <div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                            <div id="strength-bar" class="h-full w-0 transition-all duration-200 rounded-full"></div>
                        </div>
                        <p id="strength-label" class="form-hint">Kosongkan kalau tidak ingin mengganti password.</p>
                    </div>
                </div>

                <div>
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control w-full" minlength="8">
                </div>

                <div class="grid sm:grid-cols-2 gap-5 pt-5 border-t border-slate-100">
                    <div>
                        <label class="form-label">Role</label>
                        <select name="role" id="role" class="form-control w-full" required
                                onchange="document.getElementById('class-wrapper').style.display = this.value === 'guru' ? 'block' : 'none'">
                            <option value="guru" {{ old('role', $user->role) === 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div id="class-wrapper">
                        <label class="form-label">Kelas yang Diwalikan</label>
                        <select name="class_id" class="form-control w-full">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('class_id', $user->class_id) == $class->id)>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('users.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const wrapper = document.getElementById('class-wrapper');
            wrapper.style.display = roleSelect.value === 'guru' ? 'block' : 'none';
        });

        const pwInput = document.getElementById('new-password');
        const pwBar = document.getElementById('strength-bar');
        const pwLabel = document.getElementById('strength-label');

        pwInput.addEventListener('input', function () {
            const val = pwInput.value;
            let score = 0;
            if (val.length >= 8) score++;
            if (/[a-z]/.test(val) && /[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { color: '#e5e7eb', width: '0%',   text: 'Kosongkan kalau tidak ingin mengganti password.' },
                { color: '#dc2626', width: '25%',  text: 'Lemah — tambahkan huruf besar, angka, dan simbol.' },
                { color: '#f59e0b', width: '50%',  text: 'Sedang — masih bisa lebih kuat.' },
                { color: '#eab308', width: '75%',  text: 'Cukup kuat.' },
                { color: '#16a34a', width: '100%', text: 'Kuat! Password sudah bagus.' },
            ];

            const level = val.length === 0 ? levels[0] : levels[score];
            pwBar.style.backgroundColor = level.color;
            pwBar.style.width = level.width;
            pwLabel.textContent = level.text;
            pwLabel.style.color = val.length === 0 ? '#6b7280' : level.color;
        });
    </script>
@endsection
