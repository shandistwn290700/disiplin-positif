@extends('layouts.main')

@section('content')
    <x-page-header title="Rekap Poin Siswa" subtitle="Akumulasi poin disiplin setiap siswa.">
        <a href="{{ route('reports.export.excel') }}" class="btn-secondary btn-sm">
            <x-icon name="download" class="text-emerald-600" />
            Export Excel
        </a>
        <a href="{{ route('reports.export.pdf') }}" class="btn-secondary btn-sm">
            <x-icon name="document" class="text-red-600" />
            Export PDF
        </a>
    </x-page-header>

    @include('partials.filter-bar', ['action' => route('reports.index')])

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td class="cell-strong">{{ $student->name }}</td>
                    <td class="cell-muted">{{ $student->schoolClass->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $student->total_points >= 0 ? 'badge-green' : 'badge-red' }} tabular-nums !text-[0.8125rem]">
                            {{ $student->total_points > 0 ? '+' : '' }}{{ $student->total_points }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3"><x-empty-state icon="search">Tidak ada siswa yang cocok dengan filter.</x-empty-state></td></tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-5">{{ $students->links() }}</div>
@endsection
