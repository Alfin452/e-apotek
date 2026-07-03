<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Unit::withCount('medicines')->orderBy('name', 'asc');
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        $units = $query->paginate(10)->withQueryString();
        
        return view('superadmin.units.index', compact('units', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name'
        ]);

        Unit::create([
            'name' => $request->name
        ]);

        return redirect()->route('superadmin.units.index')->with('success', 'Unit obat berhasil ditambahkan!');
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $unit->id
        ]);

        $unit->update([
            'name' => $request->name
        ]);

        return redirect()->route('superadmin.units.index')->with('success', 'Unit obat berhasil diperbarui!');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->medicines()->count() > 0) {
            return redirect()->route('superadmin.units.index')->with('error', 'Unit tidak bisa dihapus karena masih digunakan oleh data obat!');
        }

        $unit->delete();

        return redirect()->route('superadmin.units.index')->with('success', 'Unit obat berhasil dihapus!');
    }
}
