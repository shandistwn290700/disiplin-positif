@extends('layouts.main')

@section('content')
    <x-page-header title="Tambah Kelas" subtitle="Buat kelas baru untuk mengelompokkan siswa." :back="route('classes.index')" />

    <div class="max-w-2xl">
        <x-validation-errors />

        <form method="POST" action="{{ route('classes.store') }}" class="card">
            @csrf

            <div class="card-body">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: 1A - Abu Bakar Ash-Shidiq"
                       class="form-control w-full" required>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('classes.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
