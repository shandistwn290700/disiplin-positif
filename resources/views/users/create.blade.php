@extends('layouts.main')

@section('content')
    <h1 class="text-xl font-bold mb-4">Buat Akun Baru</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" required minlength="8">
            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" id="role" class="w-full border rounded p-2" required
                    onchange="document.getElementById('class-wrapper').style.display = this.value === 'guru' ? 'block' : 'none'">
                <option value="guru" {{ old('role', 'guru') === 'guru' ? 'selected' : '' }}>Guru</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div id="class-wrapper">
            <label class="block text-sm font-medium mb-1">Kelas yang Diwalikan</label>
            <select name="class_id" class="w-full border rounded p-2">
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Guru hanya bisa lihat & catat siswa di kelas ini.</p>
        </div>

        <button type="submit" class="btn-primary w-full sm:w-auto">Buat Akun</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const wrapper = document.getElementById('class-wrapper');
            wrapper.style.display = roleSelect.value === 'guru' ? 'block' : 'none';
        });
    </script>
@endsection
