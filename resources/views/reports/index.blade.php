@extends('layouts.main')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <h1 class="text-xl font-bold">Rekap Poin Siswa</h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('reports.export.excel') }}" class="btn-secondary btn-sm">
                Export Excel
            </a>
            <a href="{{ route('reports.export.pdf') }}" class="btn-secondary btn-sm">
                Export PDF
            </a>
        </div>
    </div>

    {{-- Filter kelas & pencarian nama siswa --}}
    <form method="GET" action="{{ route('reports.index') }}" class="bg-white shadow rounded p-4 mb-4 flex flex-wrap items-end gap-3">
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
            <a href="{{ route('reports.index') }}" class="btn-secondary btn-sm w-full sm:w-auto">Reset</a>
        @endif
    </form>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Kelas</th>
                <th class="p-3 text-left">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr class="border-t">
                    <td class="p-3">{{ $student->name }}</td>
                    <td class="p-3">{{ $student->schoolClass->name ?? '-' }}</td>
                    <td class="p-3 font-semibold {{ $student->total_points >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $student->total_points > 0 ? '+' : '' }}{{ $student->total_points }}
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="p-4 text-center text-gray-400">Tidak ada siswa yang cocok dengan filter.</td></tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-4">{{ $students->links() }}</div>
@endsection
