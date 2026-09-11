@extends('layouts.main')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <h1 class="text-xl font-bold">Catatan Disiplin</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('records.export.excel') }}" class="btn-secondary btn-sm">
                Export Excel
            </a>
            <a href="{{ route('records.export.pdf') }}" class="btn-secondary btn-sm">
                Export PDF
            </a>
            <a href="{{ route('records.create') }}" class="btn-primary btn-sm">
                + Tambah Catatan
            </a>
        </div>
    </div>

    {{-- Filter kelas & pencarian nama siswa --}}
    <form method="GET" action="{{ route('records.index') }}" class="bg-white shadow rounded p-4 mb-4 flex flex-wrap items-end gap-3">
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
            <a href="{{ route('records.index') }}" class="btn-secondary btn-sm w-full sm:w-auto">Reset</a>
        @endif
    </form>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th class="p-3 text-left">Tanggal</th>
                <th class="p-3 text-left">Siswa</th>
                <th class="p-3 text-left">Kode</th>
                <th class="p-3 text-left">Kategori</th>
                <th class="p-3 text-left">Tingkat</th>
                <th class="p-3 text-left">Poin</th>
                <th class="p-3 text-left">Dicatat oleh</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr class="border-t">
                    <td class="p-3">{{ $record->date->format('d M Y') }}</td>
                    <td class="p-3">{{ $record->student->name }}</td>
                    <td class="p-3">{{ $record->category->code ?? '-' }}</td>
                    <td class="p-3">
                        <span class="{{ $record->category->type === 'positif' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $record->category->name }}
                        </span>
                    </td>
                    <td class="p-3">{{ $record->category->severityLabel() ?? '-' }}</td>
                    <td class="p-3">{{ $record->category->points > 0 ? '+' : '' }}{{ $record->category->points }}</td>
                    <td class="p-3">{{ $record->recordedBy->name }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('records.destroy', $record) }}"
                              onsubmit="return confirmDelete(this, 'Catatan ini akan dihapus permanen.')">
                            @csrf @method('DELETE')
                            <button class="btn-pill btn-pill-red">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="p-4 text-center text-gray-400">Belum ada catatan.</td></tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-4">{{ $records->links() }}</div>
@endsection
