<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Supplier::withCount('medicines')->orderBy('name', 'asc');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        $suppliers = $query->paginate(10)->withQueryString();
        
        return view('superadmin.suppliers.index', compact('suppliers', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address' => 'nullable|string'
        ]);

        Supplier::create([
            'name' => $request->name,
            'contact_number' => $request->contact_number,
            'address' => $request->address
        ]);

        return redirect()->route('superadmin.suppliers.index')->with('success', 'Data pemasok berhasil ditambahkan!');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address' => 'nullable|string'
        ]);

        $supplier->update([
            'name' => $request->name,
            'contact_number' => $request->contact_number,
            'address' => $request->address
        ]);

        return redirect()->route('superadmin.suppliers.index')->with('success', 'Data pemasok berhasil diperbarui!');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->medicines()->count() > 0) {
            return redirect()->route('superadmin.suppliers.index')->with('error', 'Pemasok tidak bisa dihapus karena masih terkait dengan data obat!');
        }

        $supplier->delete();

        return redirect()->route('superadmin.suppliers.index')->with('success', 'Data pemasok berhasil dihapus!');
    }
}
