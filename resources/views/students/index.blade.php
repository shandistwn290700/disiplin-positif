@extends('layouts.main')

@section('content')
    <x-page-header title="Data Siswa" subtitle="Daftar siswa beserta kelasnya.">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('students.import') }}" class="btn-secondary btn-sm">
                <x-icon name="upload" />
                Import Massal
            </a>
            <a href="{{ route('students.create') }}" class="btn-primary btn-sm">
                <x-icon name="plus" />
                Tambah Siswa
            </a>
        @endif
    </x-page-header>

    @if(session('import_skipped') && count(session('import_skipped')) > 0)
        <div class="alert alert-warning mb-5">
            <x-icon name="warning" />
            <div>
                <p class="font-semibold mb-1">Beberapa baris dilewati:</p>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach(session('import_skipped') as $skip)
                        <li>{{ $skip }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @include('partials.filter-bar', ['action' => route('students.index')])

    <div class="table-scroll"><table class="table-fresh">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                @if(auth()->user()->isAdmin())
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td><span class="badge-code">{{ $student->nis }}</span></td>
                    <td class="cell-strong">{{ $student->name }}</td>
                    <td>
                        @if($student->schoolClass)
                            <span class="badge badge-blue">{{ $student->schoolClass->name }}</span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    @if(auth()->user()->isAdmin())
                        <td class="cell-actions">
                            <a href="{{ route('students.edit', $student) }}" class="btn-pill btn-pill-blue"><x-icon name="pencil" /> Ubah</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline"
                                  onsubmit="return confirmDelete(this, 'Data siswa ini akan dihapus permanen.')">
                                @csrf @method('DELETE')
                                <button class="btn-pill btn-pill-red"><x-icon name="trash" /> Hapus</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->isAdmin() ? 4 : 3 }}">
                        <x-empty-state icon="search">Tidak ada siswa yang cocok dengan filter.</x-empty-state>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table></div>

    <div class="mt-5">{{ $students->links() }}</div>
@endsection
