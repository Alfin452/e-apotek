<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Storage::withCount('medicines')->orderBy('name', 'asc');
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        $storages = $query->paginate(10)->withQueryString();
        
        return view('superadmin.storages.index', compact('storages', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:storages,name',
            'description' => 'nullable|string'
        ]);

        Storage::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('superadmin.storages.index')->with('success', 'Lokasi penyimpanan berhasil ditambahkan!');
    }

    public function update(Request $request, Storage $storage)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:storages,name,' . $storage->id,
            'description' => 'nullable|string'
        ]);

        $storage->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('superadmin.storages.index')->with('success', 'Lokasi penyimpanan berhasil diperbarui!');
    }

    public function destroy(Storage $storage)
    {
        if ($storage->medicines()->count() > 0) {
            return redirect()->route('superadmin.storages.index')->with('error', 'Lokasi penyimpanan tidak bisa dihapus karena masih digunakan oleh data obat!');
        }

        $storage->delete();

        return redirect()->route('superadmin.storages.index')->with('success', 'Lokasi penyimpanan berhasil dihapus!');
    }
}
