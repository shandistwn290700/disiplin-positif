@extends('layouts.main')

@section('content')
    <x-page-header title="Tambah Siswa" subtitle="Daftarkan siswa baru ke dalam kelas." :back="route('students.index')" />

    <div class="max-w-2xl">
        <x-validation-errors />

        <form method="POST" action="{{ route('students.store') }}" class="card">
            @csrf

            <div class="card-body space-y-5">
                <div>
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" class="form-control w-full sm:w-60" required>
                </div>

                <div>
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control w-full" required>
                </div>

                <div>
                    <label class="form-label">Kelas</label>
                    <select name="class_id" class="form-control w-full" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('students.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
