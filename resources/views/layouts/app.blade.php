<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>MoNgapain - @yield('title', 'Tugas Saya')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-background": "#1a1c1c",
                        "inverse-primary": "#9ecaff",
                        "on-surface": "#1a1c1c",
                        "inverse-surface": "#2f3131",
                        "secondary": "#006e1c",
                        "surface-variant": "#e2e2e2",
                        "surface-bright": "#f9f9f9",
                        "on-error-container": "#93000a",
                        "primary-container": "#2196f3",
                        "surface-tint": "#0061a4",
                        "on-primary": "#ffffff",
                        "surface-container-high": "#e8e8e8",
                        "inverse-on-surface": "#f1f1f1",
                        "on-surface-variant": "#404752",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#eeeeee",
                        "surface": "#f9f9f9",
                        "surface-dim": "#dadada",
                        "outline": "#707883",
                        "surface-container-low": "#f3f3f3",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "primary-fixed-dim": "#9ecaff",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "primary": "#0061a4",
                        "primary-fixed": "#d1e4ff",
                        "on-primary-container": "#002c4f",
                        "on-primary-fixed": "#001d36",
                        "surface-container-highest": "#e2e2e2",
                        "error": "#ba1a1a",
                        "outline-variant": "#bfc7d4",
                        "background": "#f9f9f9",
                    },
                    fontFamily: {
                        "body-md": ["Manrope"],
                        "body-sm": ["Manrope"],
                        "label-md": ["Manrope"],
                        "label-sm": ["Manrope"],
                        "h1": ["Manrope"],
                        "h2": ["Manrope"],
                        "h3": ["Manrope"],
                    },
                    fontSize: {
                        "h1": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "h2": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "h3": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                        "label-md": ["14px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "600" }],
                        "label-sm": ["12px", { lineHeight: "14px", fontWeight: "500" }],
                        "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "body-sm": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                    },
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-background text-on-background font-body-md h-screen flex flex-col md:flex-row overflow-hidden">

    {{-- Mobile Top Nav --}}
    <header class="md:hidden fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 h-16
                   bg-surface-bright/80 backdrop-blur-md border-b border-surface-variant shadow-sm">
        <div class="flex items-center space-x-2">
            <span class="material-symbols-outlined text-primary-container" style="font-variation-settings:'FILL' 1;">task_alt</span>
            <span class="font-h3 text-h3 text-on-background tracking-tight">MoNgapain</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="font-body-sm text-sm text-on-surface-variant">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center text-outline hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-xl">logout</span>
                </button>
            </form>
        </div>
    </header>

    {{-- Desktop Side Nav --}}
    <nav class="hidden md:flex flex-col p-4 space-y-2 bg-surface-bright border-r border-surface-variant h-screen w-64 z-10 shrink-0">
        {{-- Logo --}}
        <div class="flex items-center space-x-3 mb-8 px-4 mt-2">
            <span class="material-symbols-outlined text-primary-container text-[32px]" style="font-variation-settings:'FILL' 1;">task_alt</span>
            <span class="font-h2 text-h2 text-on-background tracking-tight">MoNgapain</span>
        </div>

        {{-- User Info --}}
        <div class="flex items-center space-x-3 px-4 py-4 mb-6 bg-surface-container-low rounded-lg border border-surface-variant">
            @if (Auth::user()->profile_photo_url)
                <img src="{{ Auth::user()->profile_photo_url }}"
                     alt="Foto Profil"
                     class="w-10 h-10 rounded-full object-cover border border-surface-variant" />
            @else
                <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-container font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            @endif
            <div class="overflow-hidden">
                <p class="font-label-md text-label-md text-on-background truncate">{{ Auth::user()->name }}</p>
                <p class="font-label-sm text-label-sm text-outline">Mode Produktif</p>
            </div>
        </div>

        {{-- Add Task Button --}}
        <a href="{{ route('todos.create') }}"
           class="w-full bg-primary-container text-on-primary font-label-md text-label-md py-3 px-4 rounded-lg
                  flex items-center justify-center space-x-2 mb-6 hover:bg-surface-tint transition-colors duration-200">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span>+ Tambah Tugas</span>
        </a>

        {{-- Nav Links --}}
        <div class="space-y-1 flex-1">
            <a href="{{ route('todos.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all cursor-pointer
                      {{ request()->routeIs('todos.index') ? 'bg-primary-fixed/20 text-primary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
                <span class="material-symbols-outlined text-[20px]"
                      style="{{ request()->routeIs('todos.index') ? 'font-variation-settings:\'FILL\' 1' : '' }}">checklist</span>
                <span class="font-body-sm text-body-sm">Tugas Saya</span>
            </a>

            <a href="{{ route('todos.completed') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all cursor-pointer
                      {{ request()->routeIs('todos.completed') ? 'bg-primary-fixed/20 text-primary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
                <span class="material-symbols-outlined text-[20px]"
                      style="{{ request()->routeIs('todos.completed') ? 'font-variation-settings:\'FILL\' 1' : '' }}">history</span>
                <span class="font-body-sm text-body-sm">Tugas Selesai</span>
            </a>

        <a href="{{ route('categories.index') }}"
           class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all cursor-pointer
                {{ request()->routeIs('categories.*') ? 'bg-primary-fixed/20 text-primary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
            <span class="material-symbols-outlined text-[20px]"
                style="{{ request()->routeIs('categories.*') ? 'font-variation-settings:\'FILL\' 1' : '' }}">label</span>
            <span class="font-body-sm text-body-sm">Kategori</span>
        </a>

            <a href="{{ route('settings.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all cursor-pointer
                      {{ request()->routeIs('settings.*') ? 'bg-primary-fixed/20 text-primary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container-low' }}">
                <span class="material-symbols-outlined text-[20px]"
                      style="{{ request()->routeIs('settings.*') ? 'font-variation-settings:\'FILL\' 1' : '' }}">settings</span>
                <span class="font-body-sm text-body-sm">Pengaturan</span>
            </a>
        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit"
                    class="w-full flex items-center space-x-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-low
                           hover:text-error transition-all rounded-lg cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">logout</span>
                <span class="font-body-sm text-body-sm">Keluar</span>
            </button>
        </form>
    </nav>

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto bg-background pt-20 md:pt-0 p-4 md:p-8 lg:p-12">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-6 max-w-5xl mx-auto flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-green-800 font-body-sm text-body-sm">
                <span class="material-symbols-outlined text-green-600 text-xl" style="font-variation-settings:'FILL' 1;">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-inverse-surface/40 backdrop-blur-sm">
        <div class="bg-surface-container-lowest w-full max-w-md rounded-xl shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] overflow-hidden flex flex-col">
            <div class="px-6 pt-6 pb-4 flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-error-container text-on-error-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1;">delete</span>
                </div>
                <div>
                    <h2 class="font-h2 text-h2 text-on-surface mb-2">Hapus tugas?</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Yakin ingin menghapus tugas ini? Aksi ini tidak bisa dibatalkan.
                    </p>
                </div>
            </div>
            <div class="px-6 py-4 bg-surface-container-low/50 border-t border-surface-container-high flex items-center justify-end gap-3">
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-lg font-label-md text-label-md text-on-surface hover:bg-surface-container-high transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg font-label-md text-label-md bg-error text-on-error hover:opacity-90 shadow-sm transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(todoId) {
            document.getElementById('deleteForm').action = `/todos/${todoId}/delete`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        // Close modal on backdrop click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    </script>
</body>
</html>
