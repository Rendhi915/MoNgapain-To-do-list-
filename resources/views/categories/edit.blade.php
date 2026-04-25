@extends('layouts.app')

@section('title', 'Ubah Kategori')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <a href="{{ route('categories.index') }}"
           class="inline-flex items-center gap-2 text-outline hover:text-on-background transition-colors duration-200 mb-3">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            <span class="font-body-sm text-body-sm">Kembali ke Kategori</span>
        </a>
        <h1 class="font-h1 text-h1 text-on-surface">Ubah Kategori</h1>
        <p class="font-body-sm text-body-sm text-outline mt-1">Perbarui nama atau warna kategori</p>
    </div>

    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-sm p-6 md:p-8">
        @if ($errors->any())
            <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm flex items-start gap-2">
                <span class="material-symbols-outlined text-red-500 text-lg mt-0.5" style="font-variation-settings:'FILL' 1;">error</span>
                <ul class="list-none space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="name">
                    Nama Kategori <span class="text-error">*</span>
                </label>
                <input id="name" name="name" type="text" maxlength="50"
                       value="{{ old('name', $category->name) }}"
                       class="w-full px-4 py-3 bg-surface-bright border border-surface-variant rounded-lg
                              font-body-md text-body-md text-on-background focus:outline-none
                              focus:border-primary-container focus:ring-1 focus:ring-primary-container
                              transition-colors duration-200 @error('name') border-error @enderror"
                       placeholder="Contoh: Kerja" required>
                @error('name')
                    <p class="mt-1 text-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="color">
                    Warna Kategori <span class="text-error">*</span>
                </label>
                <input id="color" name="color" type="color" value="{{ old('color', $category->color) }}"
                       class="h-12 w-24 p-1 bg-surface-bright border border-surface-variant rounded-lg cursor-pointer">
                @error('color')
                    <p class="mt-1 text-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-6 border-t border-surface-variant flex items-center justify-end gap-3">
                <a href="{{ route('categories.index') }}"
                   class="px-6 py-2.5 rounded-lg font-label-md text-label-md text-primary-container
                          bg-[#E3F2FD] hover:bg-primary-fixed transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg font-label-md text-label-md text-on-primary
                               bg-[#2196F3] hover:bg-surface-tint shadow-sm transition-colors duration-200
                               flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
