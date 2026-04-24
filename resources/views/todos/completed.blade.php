@extends('layouts.app')

@section('title', 'Tugas Selesai')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-h1 text-h1 text-on-surface">Tugas Selesai</h1>
            <p class="font-body-sm text-body-sm text-outline mt-1">
                Total {{ $completedTasks->count() }} riwayat tugas selesai
            </p>
        </div>
        <a href="{{ route('todos.index') }}"
           class="flex items-center gap-2 px-5 py-2.5 bg-primary-container text-on-primary rounded-lg
                  font-label-md text-label-md hover:bg-surface-tint transition-colors duration-200 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Tugas Saya
        </a>
    </div>

    @if ($completedTasks->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-4xl text-outline" style="font-variation-settings:'FILL' 1;">history</span>
            </div>
            <h3 class="font-h3 text-h3 text-on-surface mb-2">Belum ada riwayat tugas selesai</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-xs mb-6">
                Saat kamu menyelesaikan tugas, riwayatnya akan tampil di sini.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($completedTasks as $history)
                <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm flex flex-col gap-3 p-5">
                    <div class="flex items-start justify-between gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700
                                     border border-green-200 rounded-full font-label-sm text-label-sm">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1;">check_circle</span>
                            Selesai
                        </span>

                        <span class="font-label-sm text-label-sm text-outline">
                            {{ $history->completed_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <h3 class="font-h3 text-h3 text-on-surface line-through">
                        {{ $history->title }}
                    </h3>

                    @if ($history->description)
                        <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-3">
                            {{ $history->description }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
