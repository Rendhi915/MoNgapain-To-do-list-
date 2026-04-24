@extends('layouts.app')

@section('title', 'Tugas Saya')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-h1 text-h1 text-on-surface">Tugas Saya</h1>
            <p class="font-body-sm text-body-sm text-outline mt-1">
                Total {{ $todos->count() }} tugas
            </p>
        </div>
        <a href="{{ route('todos.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-primary-container text-on-primary rounded-lg
                  font-label-md text-label-md hover:bg-surface-tint transition-colors duration-200 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Tambah Tugas
        </a>
    </div>

    {{-- Empty State --}}
    @if ($todos->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-outline" style="font-variation-settings:'FILL' 1;">checklist</span>
            </div>
            <h3 class="font-h3 text-h3 text-on-surface mb-2">Belum ada tugas</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs mb-6">
                Semua sudah beres! Buat tugas pertamamu untuk mulai.
            </p>
            <a href="{{ route('todos.create') }}"
               class="flex items-center gap-2 px-5 py-2.5 bg-primary-container text-on-primary rounded-lg
                      font-label-md text-label-md hover:bg-surface-tint transition-colors duration-200">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Buat Tugas Pertama
            </a>
        </div>

    {{-- Task Grid --}}
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($todos as $todo)
                <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm
                            flex flex-col gap-3 p-5 transition-all hover:shadow-md
                            {{ $todo->isCompleted() ? 'opacity-70' : '' }}">

                    {{-- Card Top: Status Badge + Actions --}}
                    <div class="flex items-start justify-between gap-2">
                        {{-- Status Badge --}}
                        @if ($todo->isCompleted())
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700
                                         border border-green-200 rounded-full font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">check_circle</span>
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700
                                         border border-amber-200 rounded-full font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-sm">pending</span>
                                Menunggu
                            </span>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1 ml-auto">
                            <a href="{{ route('todos.edit', $todo) }}"
                               class="p-1.5 rounded-lg text-on-surface-variant hover:bg-surface-container-high
                                      hover:text-primary-container transition-colors"
                               title="Ubah tugas">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <button onclick="confirmDelete({{ $todo->id }})"
                                    class="p-1.5 rounded-lg text-on-surface-variant hover:bg-error-container
                                           hover:text-error transition-colors"
                                    title="Hapus tugas">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </div>

                    {{-- Task Title --}}
                    <h3 class="font-h3 text-h3 text-on-surface {{ $todo->isCompleted() ? 'line-through' : '' }}">
                        {{ $todo->title }}
                    </h3>

                    {{-- Task Description --}}
                    @if ($todo->description)
                        <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3">
                            {{ $todo->description }}
                        </p>
                    @endif

                    {{-- Card Footer: Date + Quick Toggle --}}
                    <div class="mt-auto pt-4 flex items-center justify-between border-t border-surface-container-high">
                        <span class="font-label-sm text-label-sm text-outline">
                            {{ $todo->created_at->format('M d, Y') }}
                        </span>

                        {{-- Quick Toggle Status --}}
                        <form method="POST" action="{{ route('todos.update', $todo) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $todo->title }}">
                            <input type="hidden" name="description" value="{{ $todo->description }}">
                            <input type="hidden" name="status" value="{{ $todo->isCompleted() ? 'pending' : 'completed' }}">
                            <button type="submit"
                                    class="flex items-center gap-1 font-label-sm text-label-sm px-2.5 py-1 rounded-full
                                           transition-colors
                                           {{ $todo->isCompleted()
                                               ? 'bg-amber-50 text-amber-700 hover:bg-amber-100'
                                               : 'bg-green-50 text-green-700 hover:bg-green-100' }}"
                                    title="{{ $todo->isCompleted() ? 'Tandai Menunggu' : 'Tandai Selesai' }}">
                                <span class="material-symbols-outlined text-sm">
                                    {{ $todo->isCompleted() ? 'undo' : 'check' }}
                                </span>
                                {{ $todo->isCompleted() ? 'Urungkan' : 'Selesaikan' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
