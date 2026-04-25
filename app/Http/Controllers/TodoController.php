<?php

namespace App\Http\Controllers;

use App\Models\CompletedTaskHistory;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TodoController extends Controller
{
    /**
     * Display the authenticated user's todos.
     */
    public function index()
    {
        $todos = Auth::user()->todos()->with('category')->latest()->get();
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new todo.
     */
    public function create()
    {
        $categories = Auth::user()->categories()->orderBy('name')->get();

        return view('todos.create', compact('categories'));
    }

    /**
     * Store a newly created todo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(fn ($query) => $query->where('user_id', Auth::id())),
            ],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', 'in:pending,completed'],
        ], [
            'category_id.exists' => 'Kategori tidak valid.',
            'title.required' => 'Judul tugas wajib diisi.',
            'title.max' => 'Judul tugas maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 2000 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        if ($validated['status'] === 'completed') {
            CompletedTaskHistory::create([
                'user_id' => Auth::id(),
                'todo_id' => null,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'completed_at' => now(),
            ]);

            return redirect()->route('todos.completed')
                ->with('success', 'Tugas selesai langsung disimpan ke riwayat!');
        }

        Auth::user()->todos()->create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Show the form for editing a todo.
     */
    public function edit(Todo $todo)
    {
        // Ensure the authenticated user owns this todo
        abort_if($todo->user_id !== Auth::id(), 403);

        $categories = Auth::user()->categories()->orderBy('name')->get();

        return view('todos.edit', compact('todo', 'categories'));
    }

    /**
     * Update the specified todo.
     */
    public function update(Request $request, Todo $todo)
    {
        abort_if($todo->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(fn ($query) => $query->where('user_id', Auth::id())),
            ],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', 'in:pending,completed'],
        ], [
            'category_id.exists' => 'Kategori tidak valid.',
            'title.required' => 'Judul tugas wajib diisi.',
            'title.max' => 'Judul tugas maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 2000 karakter.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        $isMarkingCompleted = $validated['status'] === 'completed';

        if ($isMarkingCompleted) {
            DB::transaction(function () use ($todo, $validated): void {
                CompletedTaskHistory::create([
                    'user_id' => Auth::id(),
                    'todo_id' => $todo->id,
                    'title' => $validated['title'],
                    'description' => $validated['description'] ?? null,
                    'completed_at' => now(),
                ]);

                $todo->delete();
            });

            return redirect()->route('todos.completed')
                ->with('success', 'Tugas berhasil diselesaikan dan dipindahkan ke riwayat!');
        }

        $todo->update($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Display completed task history for the authenticated user.
     */
    public function completed()
    {
        $completedTasks = Auth::user()
            ->completedTaskHistories()
            ->latest('completed_at')
            ->get();

        return view('todos.completed', compact('completedTasks'));
    }

    /**
     * Delete the specified todo.
     */
    public function destroy(Todo $todo)
    {
        abort_if($todo->user_id !== Auth::id(), 403);

        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }
}
