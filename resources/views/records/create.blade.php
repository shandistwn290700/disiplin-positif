@extends('layouts.main')

@section('content')
    <x-page-header title="Tambah Catatan Disiplin" subtitle="Catat perilaku baik atau pelanggaran siswa." :back="route('records.index')" />

    <div class="max-w-2xl">
        <x-validation-errors />

        <form method="POST" action="{{ route('records.store') }}" class="card">
            @csrf

            <div class="card-body space-y-5">
                <div>
                    <label class="form-label">Siswa</label>
                    <select name="student_id" class="form-control w-full" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                {{ $student->name }} ({{ $student->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Kategori Pelanggaran / Pencapaian</label>
                    <select name="category_id" class="form-control w-full" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                @if($category->code)[{{ $category->code }}] @endif
                                {{ $category->name }}
                                @if($category->severityLabel())({{ $category->severityLabel() }})@endif
                                {{ $category->points > 0 ? '+' : '' }}{{ $category->points }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                           class="form-control w-full sm:w-60" required>
                </div>

                <div>
                    <label class="form-label">Deskripsi <span class="font-normal text-slate-400">(opsional)</span></label>
                    <textarea name="description" rows="3" class="form-control w-full"
                              placeholder="Ceritakan singkat kejadiannya...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="card-footer flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('records.index') }}" class="btn-secondary w-full sm:w-auto">Batal</a>
                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <x-icon name="check" />
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
