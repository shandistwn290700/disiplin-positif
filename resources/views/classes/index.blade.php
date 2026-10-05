@extends('layouts.main')

@section('content')
    <x-page-header title="Kelola Kelas" subtitle="Daftar kelas dan jumlah siswanya.">
        <a href="{{ route('classes.create') }}" class="btn-primary btn-sm">
            <x-icon name="plus" />
            Tambah Kelas
        </a>
    </x-page-header>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Jumlah Siswa</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>
                        <span class="flex items-center gap-3">
                            <span class="icon-tile !w-9 !h-9 !rounded-lg bg-brand-50 text-brand-600"><x-icon name="academic" /></span>
                            <span class="cell-strong text-slate-900 font-semibold">{{ $class->name }}</span>
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-gray tabular-nums">{{ $class->students_count }} siswa</span>
                    </td>
                    <td class="cell-actions">
                        <a href="{{ route('classes.edit', $class) }}" class="btn-pill btn-pill-blue"><x-icon name="pencil" /> Ubah</a>
                        <form method="POST" action="{{ route('classes.destroy', $class) }}" class="inline"
                              onsubmit="return confirmDelete(this, 'Kelas ini akan dihapus permanen.')">
                            @csrf @method('DELETE')
                            <button class="btn-pill btn-pill-red"><x-icon name="trash" /> Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3"><x-empty-state icon="academic">Belum ada kelas.</x-empty-state></td></tr>
            @endforelse
        </tbody>
    </table></div>
@endsection
