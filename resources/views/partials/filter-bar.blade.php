{{-- Filter kelas & pencarian nama siswa (dipakai di Catatan, Rekap Poin, dan Data Siswa) --}}
<form method="GET" action="{{ $action }}" class="card p-4 mb-5 flex flex-wrap items-end gap-3">
    @if(auth()->user()->isAdmin())
        <div class="w-full sm:w-56">
            <label class="form-label">Kelas</label>
            <select name="class_id" class="form-control w-full">
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
        <label class="form-label">Cari Nama Siswa</label>
        <div class="input-icon">
            <x-icon name="search" />
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Ketik nama siswa..." class="form-control w-full">
        </div>
    </div>

    <button type="submit" class="btn-primary w-full sm:w-auto">
        <x-icon name="funnel" />
        Filter
    </button>

    @if(request('class_id') || request('search'))
        <a href="{{ $action }}" class="btn-secondary w-full sm:w-auto">
            <x-icon name="x" />
            Reset
        </a>
    @endif
</form>
