@extends('layouts.main')

@section('content')
    <x-page-header title="Ubah Data Siswa" :subtitle="$student->name" :back="route('students.index')" />

    <div class="max-w-2xl">
        <x-validation-errors />

        <form method="POST" action="{{ route('students.update', $student) }}" class="card">
            @csrf
            @method('PUT')

            <div class="card-body space-y-5">
                <div>
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $student->nis) }}" class="form-control w-full sm:w-60" required>
                </div>

                <div>
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" class="form-control w-full" required>
                </div>

                <div>
                    <label class="form-label">Kelas</label>
                    <select name="class_id" class="form-control w-full" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('class_id', $student->class_id) == $class->id)>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('students.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
