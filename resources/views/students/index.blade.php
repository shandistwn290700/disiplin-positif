@extends('layouts.main')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <h1 class="text-xl font-bold">Data Siswa</h1>
        @if(auth()->user()->isAdmin())
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('students.import') }}" class="btn-secondary btn-sm">
                    Import Massal
                </a>
                <a href="{{ route('students.create') }}" class="btn-primary btn-sm">
                    + Tambah Siswa
                </a>
            </div>
        @endif
    </div>

    @if(session('import_skipped') && count(session('import_skipped')) > 0)
        <div class="bg-yellow-50 text-yellow-800 text-sm p-4 rounded mb-4">
            <p class="font-medium mb-1">Beberapa baris dilewati:</p>
            <ul class="list-disc pl-5">
                @foreach(session('import_skipped') as $skip)
                    <li>{{ $skip }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filter kelas & pencarian nama --}}
    <form method="GET" action="{{ route('students.index') }}" class="bg-white shadow rounded p-4 mb-4 flex flex-wrap items-end gap-3">
        @if(auth()->user()->isAdmin())
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-medium text-gray-500 mb-1">Kelas</label>
                <select name="class_id" class="w-full sm:w-auto border rounded p-2 text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ (string) request('class_id') === (string) $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="flex-1 min-w-[220px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cari Nama Siswa</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Ketik nama siswa..." class="w-full border rounded p-2 text-sm">
        </div>

        <button type="submit" class="btn-primary btn-sm w-full sm:w-auto">Filter</button>

        @if(request('class_id') || request('search'))
            <a href="{{ route('students.index') }}" class="btn-secondary btn-sm w-full sm:w-auto">Reset</a>
        @endif
    </form>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th class="p-3 text-left">NIS</th>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Kelas</th>
                @if(auth()->user()->isAdmin())
                    <th class="p-3"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr class="border-t">
                    <td class="p-3">{{ $student->nis }}</td>
                    <td class="p-3">{{ $student->name }}</td>
                    <td class="p-3">{{ $student->schoolClass->name ?? '-' }}</td>
                    @if(auth()->user()->isAdmin())
                        <td class="p-3 space-x-3">
                            <a href="{{ route('students.edit', $student) }}" class="btn-pill btn-pill-blue">Ubah</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline"
                                  onsubmit="return confirmDelete(this, 'Data siswa ini akan dihapus permanen.')">
                                @csrf @method('DELETE')
                                <button class="btn-pill btn-pill-red">Hapus</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}" class="p-4 text-center text-gray-400">
                        Tidak ada siswa yang cocok dengan filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-4">{{ $students->links() }}</div>
@endsection
