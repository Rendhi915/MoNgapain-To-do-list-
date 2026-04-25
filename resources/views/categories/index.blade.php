@extends('layouts.app')

@section('title', 'Kategori Tugas')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-h1 text-h1 text-on-surface">Kategori Tugas</h1>
            <p class="font-body-sm text-body-sm text-outline mt-1">Kelompokkan tugas kamu berdasarkan kategori</p>
        </div>
        <a href="{{ route('categories.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-primary-container text-on-primary rounded-lg
                  font-label-md text-label-md hover:bg-surface-tint transition-colors duration-200 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Kategori
        </a>
    </div>

    @if ($categories->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-outline" style="font-variation-settings:'FILL' 1;">label</span>
            </div>
            <h3 class="font-h3 text-h3 text-on-surface mb-2">Belum ada kategori</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs mb-6">
                Bikin kategori seperti "Kerja", "Pribadi", atau "Belajar" biar tugas lebih rapi.
            </p>
            <a href="{{ route('categories.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 bg-primary-container text-on-primary rounded-lg
                      font-label-md text-label-md hover:bg-surface-tint transition-colors duration-200">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Buat Kategori Pertama
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($categories as $category)
                <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm p-5">
                    <div class="flex items-start justify-between gap-2">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold"
                              style="background-color: {{ $category->color }}20; color: {{ $category->color }}; border: 1px solid {{ $category->color }}55;">
                            <span class="inline-block w-2.5 h-2.5 rounded-full" style="background-color: {{ $category->color }};"></span>
                            {{ $category->name }}
                        </span>

                        <div class="flex items-center gap-1 ml-auto">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high hover:text-primary-container transition-colors"
                               title="Ubah kategori">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>

                            <button type="button"
                                    onclick="openCategoryDeleteModal({{ $category->id }}, '{{ addslashes($category->name) }}')"
                                    class="p-1.5 rounded-lg text-on-surface-variant hover:bg-error-container hover:text-error transition-colors"
                                    title="Hapus kategori">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-surface-container-high flex items-center justify-between">
                        <span class="font-label-sm text-label-sm text-outline">{{ $category->todos_count }} tugas</span>
                        <span class="font-label-sm text-label-sm text-outline">{{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Category Delete Confirmation Modal --}}
<div id="categoryDeleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-inverse-surface/40 backdrop-blur-sm">
    <div class="bg-surface-container-lowest w-full max-w-md rounded-xl shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] overflow-hidden flex flex-col">
        <div class="px-6 pt-6 pb-4 flex items-start gap-4">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-error-container text-on-error-container flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1;">delete</span>
            </div>
            <div>
                <h2 class="font-h2 text-h2 text-on-surface mb-2">Hapus kategori?</h2>
                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    Kategori <span id="categoryName" class="font-semibold text-on-surface"></span> akan dihapus. Tugas terkait akan tetap ada, tapi tanpa kategori.
                </p>
            </div>
        </div>
        <div class="px-6 py-4 bg-surface-container-low/50 border-t border-surface-container-high flex items-center justify-end gap-3">
            <button onclick="closeCategoryDeleteModal()"
                    class="px-4 py-2 rounded-lg font-label-md text-label-md text-on-surface hover:bg-surface-container-high transition-colors">
                Batal
            </button>
            <form id="categoryDeleteForm" method="POST" action="">
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
    function openCategoryDeleteModal(categoryId, categoryName) {
        document.getElementById('categoryDeleteForm').action = `{{ url('/categories') }}/${categoryId}/delete`;
        document.getElementById('categoryName').textContent = categoryName;
        document.getElementById('categoryDeleteModal').classList.remove('hidden');
    }

    function closeCategoryDeleteModal() {
        document.getElementById('categoryDeleteModal').classList.add('hidden');
    }

    document.getElementById('categoryDeleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCategoryDeleteModal();
        }
    });
</script>
@endsection
