@extends('layouts.main')

@section('content')
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
        <h1 class="text-xl font-bold">Kelola Kelas</h1>
        <a href="{{ route('classes.create') }}" class="btn-primary btn-sm">
            + Tambah Kelas
        </a>
    </div>

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th class="p-3 text-left">Nama Kelas</th>
                <th class="p-3 text-left">Jumlah Siswa</th>
                <th class="p-3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $class)
                <tr class="border-t">
                    <td class="p-3">{{ $class->name }}</td>
                    <td class="p-3">{{ $class->students_count }}</td>
                    <td class="p-3 space-x-3">
                        <a href="{{ route('classes.edit', $class) }}" class="btn-pill btn-pill-blue">Ubah</a>
                        <form method="POST" action="{{ route('classes.destroy', $class) }}" class="inline"
                              onsubmit="return confirmDelete(this, 'Kelas ini akan dihapus permanen.')">
                            @csrf @method('DELETE')
                            <button class="btn-pill btn-pill-red">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table></div>
@endsection
