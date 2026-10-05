@extends('layouts.main')

@section('content')
    <x-page-header title="Ubah Kelas" :subtitle="$class->name" :back="route('classes.index')" />

    <div class="max-w-2xl">
        <x-validation-errors />

        <form method="POST" action="{{ route('classes.update', $class) }}" class="card">
            @csrf
            @method('PUT')

            <div class="card-body">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="name" value="{{ old('name', $class->name) }}"
                       class="form-control w-full" required>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('classes.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
