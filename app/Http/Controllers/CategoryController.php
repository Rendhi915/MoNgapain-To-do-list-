<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display all categories for the authenticated user.
     */
    public function index()
    {
        $categories = Auth::user()
            ->categories()
            ->withCount('todos')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show create category form.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a new category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories', 'name')->where(fn ($query) => $query->where('user_id', Auth::id())),
            ],
            'color' => ['required', 'regex:/^#[A-Fa-f0-9]{6}$/'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 50 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'color.required' => 'Warna kategori wajib dipilih.',
            'color.regex' => 'Format warna tidak valid.',
        ]);

        Auth::user()->categories()->create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Show edit category form.
     */
    public function edit(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('categories', 'name')
                    ->where(fn ($query) => $query->where('user_id', Auth::id()))
                    ->ignore($category->id),
            ],
            'color' => ['required', 'regex:/^#[A-Fa-f0-9]{6}$/'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 50 karakter.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'color.required' => 'Warna kategori wajib dipilih.',
            'color.regex' => 'Format warna tidak valid.',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Delete the specified category.
     */
    public function destroy(Category $category)
    {
        abort_if($category->user_id !== Auth::id(), 403);

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
