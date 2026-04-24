@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div>
        <h1 class="font-h1 text-h1 text-on-surface">Pengaturan Akun</h1>
        <p class="font-body-sm text-body-sm text-outline mt-1">Kelola profil, nama pengguna, foto, dan kata sandi akunmu.</p>
    </div>

    @if ($errors->any())
        <div class="px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-sm p-6 md:p-8">
        <h2 class="font-h2 text-h2 text-on-surface mb-6">Profil Akun</h2>

        <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                @if (Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}"
                         alt="Foto Profil"
                         class="w-16 h-16 rounded-full object-cover border border-surface-variant" />
                @else
                    <div class="w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center text-on-primary-container font-bold text-lg">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                @endif

                <div>
                    <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="profile_photo">
                        Foto Profil
                    </label>
                    <input id="profile_photo"
                           name="profile_photo"
                           type="file"
                           accept="image/png,image/jpeg,image/jpg,image/webp"
                           class="block w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0 file:bg-primary-fixed file:text-primary-container
                                  hover:file:bg-primary-fixed-dim" />
                    <p class="text-xs text-outline mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
                </div>
            </div>

            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="name">
                    Username / Nama Pengguna
                </label>
                <input id="name"
                       name="name"
                       type="text"
                       required
                       value="{{ old('name', Auth::user()->name) }}"
                       class="w-full px-4 py-3 bg-surface-bright border border-surface-variant rounded-lg
                              font-body-md text-body-md text-on-background
                              focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container" />
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg font-label-md text-label-md text-on-primary
                               bg-[#2196F3] hover:bg-surface-tint shadow-sm transition-colors duration-200">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-sm p-6 md:p-8">
        <h2 class="font-h2 text-h2 text-on-surface mb-3">Ubah Kata Sandi</h2>
        <p class="font-body-sm text-body-sm text-outline mb-6">
            Kamu bisa mengubah kata sandi kapan saja. Jika lupa kata sandi lama, kosongkan kolom "kata sandi saat ini" lalu isi kata sandi baru.
        </p>

        <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="current_password">
                    Kata Sandi Saat Ini (opsional)
                </label>
                <input id="current_password"
                       name="current_password"
                       type="password"
                       class="w-full px-4 py-3 bg-surface-bright border border-surface-variant rounded-lg
                              font-body-md text-body-md text-on-background
                              focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container" />
            </div>

            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="password">
                    Kata Sandi Baru
                </label>
                <input id="password"
                       name="password"
                       type="password"
                       required
                       class="w-full px-4 py-3 bg-surface-bright border border-surface-variant rounded-lg
                              font-body-md text-body-md text-on-background
                              focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container" />
            </div>

            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="password_confirmation">
                    Konfirmasi Kata Sandi Baru
                </label>
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password"
                       required
                       class="w-full px-4 py-3 bg-surface-bright border border-surface-variant rounded-lg
                              font-body-md text-body-md text-on-background
                              focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container" />
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg font-label-md text-label-md text-on-primary
                               bg-[#2196F3] hover:bg-surface-tint shadow-sm transition-colors duration-200">
                    Simpan Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
