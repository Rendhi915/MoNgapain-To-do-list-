@extends('layouts.app')

@section('title', 'Ubah Tugas')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <a href="{{ route('todos.index') }}"
           class="inline-flex items-center gap-2 text-outline hover:text-on-background transition-colors duration-200 mb-3">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            <span class="font-body-sm text-body-sm">Kembali ke Tugas Saya</span>
        </a>
        <h1 class="font-h1 text-h1 text-on-surface">Ubah Tugas</h1>
        <p class="font-body-sm text-body-sm text-outline mt-1">Perbarui detail dan status tugas</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-surface-container-lowest rounded-xl border border-surface-variant shadow-sm p-6 md:p-8">

        {{-- Validation Errors --}}
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

        <form action="{{ route('todos.update', $todo) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Category --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block font-label-md text-label-md text-on-surface-variant" for="category_id">
                        Kategori <span class="text-outline font-normal">(opsional)</span>
                    </label>
                    <a href="{{ route('categories.create') }}" class="text-sm text-primary-container hover:underline">
                        + Buat Kategori
                    </a>
                </div>
                <div class="relative">
                    <select class="w-full appearance-none px-4 py-3 pr-10 bg-surface-bright border border-surface-variant
                                   rounded-lg font-body-md text-body-md text-on-background
                                   focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container
                                   transition-colors duration-200"
                            id="category_id" name="category_id">
                        <option value="">Tanpa Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) old('category_id', $todo->category_id) === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">expand_more</span>
                    </div>
                </div>
                @error('category_id')
                    <p class="mt-1 text-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Title --}}
            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="title">
                    Judul <span class="text-error">*</span>
                </label>
                <input class="w-full px-4 py-3 bg-surface-bright border border-surface-variant rounded-lg
                              font-body-md text-body-md text-on-background
                              focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container
                              transition-colors duration-200 @error('title') border-error @enderror"
                       id="title" name="title" type="text"
                       placeholder="Masukkan judul tugas"
                       value="{{ old('title', $todo->title) }}" required/>
                @error('title')
                    <p class="mt-1 text-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="description">
                    Deskripsi <span class="text-outline font-normal">(opsional)</span>
                </label>
                <textarea class="w-full px-4 py-3 bg-surface-bright border border-surface-variant rounded-lg
                                 font-body-md text-body-md text-on-background resize-y
                                 focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container
                                 transition-colors duration-200"
                          id="description" name="description" rows="5"
                          placeholder="Tambahkan deskripsi tugas...">{{ old('description', $todo->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="status">
                    Status
                </label>
                <div class="relative">
                    <select class="w-full appearance-none px-4 py-3 pr-10 bg-surface-bright border border-surface-variant
                                   rounded-lg font-body-md text-body-md text-on-background
                                   focus:outline-none focus:border-primary-container focus:ring-1 focus:ring-primary-container
                                   transition-colors duration-200"
                            id="status" name="status">
                        <option value="pending" {{ old('status', $todo->status) === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="completed" {{ old('status', $todo->status) === 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">expand_more</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="pt-6 border-t border-surface-variant flex items-center justify-between">
                {{-- Danger: Delete on edit page too --}}
                <button type="button"
                        onclick="confirmDelete({{ $todo->id }})"
                        class="px-4 py-2.5 rounded-lg font-label-md text-label-md text-error
                               hover:bg-error-container transition-colors duration-200 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                    Hapus Tugas
                </button>

                <div class="flex items-center gap-3">
                    <a href="{{ route('todos.index') }}"
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
            </div>
        </form>
    </div>
</div>
@endsection
