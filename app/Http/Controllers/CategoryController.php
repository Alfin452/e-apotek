<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Category::withCount('medicines')->orderBy('name', 'asc');
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        $categories = $query->paginate(10)->withQueryString();
        
        return view('superadmin.categories.index', compact('categories', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori obat berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori obat berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->medicines()->count() > 0) {
            return redirect()->route('superadmin.categories.index')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh data obat!');
        }

        $category->delete();

        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori obat berhasil dihapus!');
    }
}
