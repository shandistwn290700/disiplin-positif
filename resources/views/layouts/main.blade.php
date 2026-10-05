<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Disiplin Positif</title>
    @include('partials.favicon')
    @include('partials.theme')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Sidebar */
        .sidebar { background: #fff; border-right: 1px solid var(--line); }
        .sidebar-section { padding: 1rem 0.9rem 0.4rem; font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--subtle); }
        .sidebar-link, .sidebar-group-label {
            display: flex; align-items: center; gap: 0.75rem; width: 100%;
            padding: 0.6rem 0.8rem; border-radius: 0.7rem; font-size: 0.875rem; font-weight: 500;
            color: #475569; transition: background-color .12s ease, color .12s ease;
        }
        .sidebar-link svg, .sidebar-group-label svg { width: 1.2rem; height: 1.2rem; flex-shrink: 0; color: #94a3b8; transition: color .12s ease; }
        .sidebar-link:hover, .sidebar-group-label:hover { background-color: #f4f7fb; color: var(--ink); }
        .sidebar-link:hover svg, .sidebar-group-label:hover svg { color: var(--brand-600); }
        .sidebar-link.active {
            color: #fff; background: linear-gradient(135deg, var(--brand-600), var(--brand-700));
            box-shadow: 0 8px 18px -8px rgba(29, 78, 216, .6);
        }
        .sidebar-link.active svg { color: #fff; }
        .sidebar-group-label { cursor: pointer; justify-content: space-between; }
        .sidebar-group-label.has-active { color: var(--brand-700); }
        .sidebar-group-label.has-active > span svg { color: var(--brand-600); }
        .sidebar-submenu { overflow: hidden; max-height: 0; transition: max-height .25s ease; }
        .sidebar-submenu.open { max-height: 320px; }
        .sidebar-submenu-inner { margin: 0.2rem 0 0.35rem 1.4rem; padding-left: 0.85rem; border-left: 1px solid var(--line); }
        .sidebar-submenu a {
            position: relative; display: block; padding: 0.45rem 0.75rem; margin: 0.1rem 0;
            font-size: 0.8125rem; font-weight: 500; color: var(--muted); border-radius: 0.55rem;
            transition: background-color .12s ease, color .12s ease;
        }
        .sidebar-submenu a:hover { background-color: #f4f7fb; color: var(--ink); }
        .sidebar-submenu a.active { color: var(--brand-700); font-weight: 600; background-color: var(--brand-50); }
        .sidebar-submenu a.active::before {
            content: ''; position: absolute; left: calc(-0.85rem - 1px); top: 0.45rem; bottom: 0.45rem;
            width: 2px; border-radius: 2px; background: var(--brand-600);
        }
        .chevron { width: 1rem !important; height: 1rem !important; transition: transform .2s ease; }
        .chevron.rotated { transform: rotate(90deg); }

        .topbar { background: rgba(245, 247, 251, 0.82); backdrop-filter: saturate(180%) blur(10px); -webkit-backdrop-filter: saturate(180%) blur(10px); border-bottom: 1px solid rgba(230, 234, 241, .8); }
    </style>
</head>
<body class="text-slate-700 overflow-x-hidden" style="background: var(--bg)">
    @php
        $authUser = auth()->user();
        $siteSetting = \App\Models\SiteSetting::current();
        $userInitials = collect(preg_split('/\s+/', trim($authUser->name)))
            ->filter()->take(2)
            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');
        $userRoleLabel = $authUser->isAdmin() ? 'Administrator' : 'Guru' . ($authUser->schoolClass ? ' · ' . $authUser->schoolClass->name : '');

        $administrasiOpen = request()->routeIs('students.*') || request()->routeIs('classes.*');
        $pencatatanOpen = request()->routeIs('records.*') || request()->routeIs('reports.*') || request()->routeIs('summon.*');
        $pengaturanOpen = request()->routeIs('settings.*') || request()->routeIs('categories.*');
    @endphp

    <div id="page-loader" class="fixed inset-0 z-[60] flex items-center justify-center transition-opacity duration-300" style="background: var(--bg)">
        <div class="flex flex-col items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center shadow-lg shadow-brand-600/30 animate-pulse">
                <x-icon name="shield" class="w-6 h-6" />
            </div>
            <div class="w-24 h-1 rounded-full bg-brand-100 overflow-hidden">
                <div class="h-full w-1/2 rounded-full bg-brand-600 animate-[loader_1s_ease-in-out_infinite]"></div>
            </div>
        </div>
        <style>@keyframes loader { 0% { transform: translateX(-100%); } 100% { transform: translateX(200%); } }</style>
    </div>

    <div class="min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar" class="sidebar w-[17rem] flex flex-col fixed inset-y-0 left-0 z-40 -translate-x-full lg:translate-x-0 transition-transform duration-200">
            <div class="px-5 h-[4.25rem] flex items-center gap-3 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-white flex items-center justify-center shadow-md shadow-brand-600/25">
                    <x-icon name="shield" class="w-5 h-5" />
                </div>
                <div class="min-w-0">
                    <p class="font-extrabold text-[0.95rem] leading-tight text-slate-900 tracking-tight">Disiplin Positif</p>
                    <p class="text-[0.7rem] text-slate-400 truncate">{{ $siteSetting->school_name ?: 'Sistem Pencatatan Disiplin' }}</p>
                </div>
                <button type="button" onclick="toggleSidebar()" class="ml-auto lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup menu">
                    <x-icon name="x" class="w-5 h-5" />
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 pb-4 space-y-0.5">
                <p class="sidebar-section">Menu Utama</p>

                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <x-icon name="grid" />
                    Dashboard
                </a>

                @if($authUser->isAdmin())
                    <div>
                        <button type="button" class="sidebar-group-label {{ $administrasiOpen ? 'has-active' : '' }}" onclick="toggleGroup('grp-administrasi')">
                            <span class="flex items-center gap-3">
                                <x-icon name="library" />
                                Administrasi
                            </span>
                            <svg id="chev-grp-administrasi" class="chevron {{ $administrasiOpen ? 'rotated' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                        </button>
                        <div id="grp-administrasi" class="sidebar-submenu {{ $administrasiOpen ? 'open' : '' }}">
                            <div class="sidebar-submenu-inner">
                                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Data Siswa</a>
                                <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">Kelas</a>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Guru: hanya boleh lihat & cari data siswa di kelasnya sendiri, tanpa kelola kelas --}}
                    <a href="{{ route('students.index') }}" class="sidebar-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <x-icon name="academic" />
                        Data Siswa
                    </a>
                @endif

                <div>
                    <button type="button" class="sidebar-group-label {{ $pencatatanOpen ? 'has-active' : '' }}" onclick="toggleGroup('grp-pencatatan')">
                        <span class="flex items-center gap-3">
                            <x-icon name="clipboard" />
                            Pencatatan
                        </span>
                        <svg id="chev-grp-pencatatan" class="chevron {{ $pencatatanOpen ? 'rotated' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                    </button>
                    <div id="grp-pencatatan" class="sidebar-submenu {{ $pencatatanOpen ? 'open' : '' }}">
                        <div class="sidebar-submenu-inner">
                            <a href="{{ route('records.create') }}" class="{{ request()->routeIs('records.create') ? 'active' : '' }}">Catat Perilaku</a>
                            <a href="{{ route('records.index') }}" class="{{ request()->routeIs('records.index') ? 'active' : '' }}">Riwayat Catatan</a>
                            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Poin Siswa</a>
                            <a href="{{ route('summon.index') }}" class="{{ request()->routeIs('summon.*') ? 'active' : '' }}">Pemanggilan</a>
                        </div>
                    </div>
                </div>

                @if($authUser->isAdmin())
                    <p class="sidebar-section">Admin</p>

                    <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <x-icon name="users" />
                        Kelola Akun
                    </a>

                    <div>
                        <button type="button" class="sidebar-group-label {{ $pengaturanOpen ? 'has-active' : '' }}" onclick="toggleGroup('grp-pengaturan')">
                            <span class="flex items-center gap-3">
                                <x-icon name="cog" />
                                Pengaturan
                            </span>
                            <svg id="chev-grp-pengaturan" class="chevron {{ $pengaturanOpen ? 'rotated' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                        </button>
                        <div id="grp-pengaturan" class="sidebar-submenu {{ $pengaturanOpen ? 'open' : '' }}">
                            <div class="sidebar-submenu-inner">
                                <a href="{{ route('settings.edit') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">Tampilan</a>
                                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
                            </div>
                        </div>
                    </div>
                @endif
            </nav>

            <div class="p-3 border-t border-slate-100 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition {{ request()->routeIs('profile.*') ? 'bg-brand-50' : '' }}">
                    <span class="avatar">{{ $userInitials }}</span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-slate-800 truncate">{{ $authUser->name }}</span>
                        <span class="block text-xs text-slate-400 truncate">{{ $userRoleLabel }}</span>
                    </span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link !text-red-600 hover:!bg-red-50">
                        <x-icon name="logout" class="!text-red-500" />
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Overlay untuk mobile saat sidebar terbuka --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-[2px] z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Konten utama --}}
        <div class="lg:pl-[17rem] flex flex-col min-h-screen min-w-0">
            {{-- Topbar --}}
            <header class="topbar sticky top-0 z-20 h-[4.25rem] px-4 sm:px-6 lg:px-8 flex items-center gap-3">
                <button type="button" onclick="toggleSidebar()" class="lg:hidden -ml-1 p-2 rounded-lg text-slate-600 hover:bg-white" aria-label="Buka menu">
                    <x-icon name="menu" class="w-6 h-6" />
                </button>
                <span class="lg:hidden font-extrabold text-slate-900 tracking-tight">Disiplin Positif</span>

                <div class="ml-auto flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-2 text-sm text-slate-500 bg-white border border-slate-200/80 rounded-full px-3.5 py-1.5">
                        <x-icon name="calendar" class="w-4 h-4 text-slate-400" />
                        {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                    </span>
                    <a href="{{ route('profile.edit') }}" class="avatar ring-2 ring-white shadow-sm hover:ring-brand-100 transition" title="Profil {{ $authUser->name }}">
                        {{ $userInitials }}
                    </a>
                </div>
            </header>

            <main class="flex-1 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>

            <footer class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-6 text-xs text-slate-400">
                &copy; {{ date('Y') }} Disiplin Positif{{ $siteSetting->school_name ? ' — ' . $siteSetting->school_name : '' }}
            </footer>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            const loader = document.getElementById('page-loader');
            if (loader) { loader.style.opacity = '0'; setTimeout(() => loader.remove(), 300); }
        });

        function toggleGroup(id) {
            document.getElementById(id).classList.toggle('open');
            document.getElementById('chev-' + id).classList.toggle('rotated');
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }

        function confirmDelete(form, message) {
            Swal.fire({
                title: 'Yakin?', text: message || 'Data ini akan dihapus secara permanen.', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal', reverseButtons: true,
            }).then((result) => { if (result.isConfirmed) form.submit(); });
            return false;
        }

        @if(session('success'))
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3000, timerProgressBar: true });
        @endif
        @if(session('error'))
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 4000, timerProgressBar: true });
        @endif

        @if(session('just_logged_in'))
            Swal.fire({
                title: 'Selamat datang, {{ $authUser->name }}!',
                text: @json($siteSetting->welcome_message ?: 'Senang bertemu lagi. Yuk mulai catat perkembangan siswa hari ini.'),
                icon: 'success',
                confirmButtonText: 'Mulai',
                confirmButtonColor: '#1d4ed8',
            });
        @endif
    </script>
</body>
</html>
