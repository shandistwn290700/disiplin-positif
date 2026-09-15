@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Ubah Akun</h1>

    <x-validation-errors />

    <form method="POST" action="{{ route('users.update', $user) }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password Baru (opsional)</label>
            <input type="password" name="password" id="new-password" class="w-full border rounded p-2" minlength="8">
            <div class="mt-2">
                <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div id="strength-bar" class="h-full w-0 transition-all duration-200 rounded-full"></div>
                </div>
                <p id="strength-label" class="text-xs text-gray-500 mt-1">Kosongkan kalau tidak ingin mengganti password.</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" minlength="8">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" id="role" class="w-full border rounded p-2" required
                    onchange="document.getElementById('class-wrapper').style.display = this.value === 'guru' ? 'block' : 'none'">
                <option value="guru" {{ old('role', $user->role) === 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div id="class-wrapper">
            <label class="block text-sm font-medium mb-1">Kelas yang Diwalikan</label>
            <select name="class_id" class="w-full border rounded p-2">
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(old('class_id', $user->class_id) == $class->id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Simpan Perubahan</button>
    </form>

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
