<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>MoNgapain - Daftar</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-white min-h-screen font-[Manrope] text-slate-800 antialiased">

<main class="min-h-screen flex items-center justify-center p-4 lg:p-6">
    <div class="w-full max-w-md bg-white/70 backdrop-blur-xl rounded-2xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)]
                border border-white p-6 sm:p-10 flex flex-col gap-6 transition-all duration-300">

        {{-- Header --}}
        <div class="text-center flex flex-col items-center gap-2">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-600/30">
                    <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings:'FILL' 1;">task_alt</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">MoNgapain</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mt-2">Buat akun</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar untuk mulai mengatur tugasmu.</p>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-start gap-2">
                <span class="material-symbols-outlined text-red-500 text-lg mt-0.5" style="font-variation-settings:'FILL' 1;">error</span>
                <ul class="list-none space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="/register" method="POST" class="flex flex-col gap-4">
            @csrf

            {{-- Name --}}
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-slate-700" for="name">Nama Lengkap</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-slate-400 text-xl pointer-events-none">person</span>
                    <input class="w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl text-slate-900
                                  placeholder:text-slate-400 focus:outline-none focus:bg-white focus:border-indigo-500
                                  focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 shadow-sm"
                           id="name" name="name" type="text" placeholder="John Doe"
                           value="{{ old('name') }}" required/>
                </div>
            </div>

            {{-- Email --}}
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-slate-700" for="email">Email</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-slate-400 text-xl pointer-events-none">mail</span>
                    <input class="w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl text-slate-900
                                  placeholder:text-slate-400 focus:outline-none focus:bg-white focus:border-indigo-500
                                  focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 shadow-sm"
                           id="email" name="email" type="email" placeholder="name@company.com"
                           value="{{ old('email') }}" required/>
                </div>
            </div>

            {{-- Password --}}
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-slate-700" for="password">Kata Sandi</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-slate-400 text-xl pointer-events-none">lock</span>
                    <input class="w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl text-slate-900
                                  placeholder:text-slate-400 focus:outline-none focus:bg-white focus:border-indigo-500
                                  focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 shadow-sm"
                           id="password" name="password" type="password" placeholder="Minimal 8 karakter" required/>
                </div>
            </div>

            {{-- Konfirmasi Kata Sandi --}}
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-slate-700" for="password_confirmation">Konfirmasi Kata Sandi</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-slate-400 text-xl pointer-events-none">lock_reset</span>
                    <input class="w-full pl-11 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl text-slate-900
                                  placeholder:text-slate-400 focus:outline-none focus:bg-white focus:border-indigo-500
                                  focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 shadow-sm"
                           id="password_confirmation" name="password_confirmation" type="password"
                           placeholder="Masukkan ulang kata sandi" required/>
                </div>
            </div>

            {{-- Submit --}}
            <button class="mt-2 w-full py-3 bg-indigo-600 text-white text-base font-semibold rounded-xl
                           hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-600/20 active:scale-[0.98]
                           transition-all duration-200 shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2"
                    type="submit">
                Buat Akun
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </button>
        </form>

        {{-- Footer --}}
        <div class="text-center pt-4 border-t border-slate-200/60">
            <p class="text-sm text-slate-500">
                     Sudah punya akun?
                <a class="text-indigo-600 font-semibold hover:text-indigo-800 hover:underline underline-offset-4 transition-all"
                         href="{{ route('login') }}">Masuk</a>
            </p>
        </div>
    </div>
</main>
</body>
</html>
