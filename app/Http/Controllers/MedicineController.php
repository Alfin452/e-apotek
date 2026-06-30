<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Category;
use App\Models\Storage;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category_id = $request->input('category_id');
        $type_id = $request->input('type_id');
        $supplier_id = $request->input('supplier_id');
        
        $query = Medicine::with(['storage', 'type', 'unit', 'category', 'supplier'])
            ->orderBy('expired_date', 'asc'); // Expired / Approaching expiration at top
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        if ($category_id) {
            $query->where('category_id', $category_id);
        }
        
        if ($type_id) {
            $query->where('type_id', $type_id);
        }
        
        if ($supplier_id) {
            $query->where('supplier_id', $supplier_id);
        }

        $medicines = $query->paginate(10)->withQueryString();
        $categories = Category::all();
        $types = Type::all();
        $suppliers = Supplier::all();
        
        return view('superadmin.medicines.index', compact('medicines', 'search', 'category_id', 'type_id', 'supplier_id', 'categories', 'types', 'suppliers'));
    }

    public function create()
    {
        $categories = Category::all();
        $types = Type::all();
        $units = Unit::all();
        $storages = Storage::all();
        $suppliers = Supplier::all();
        
        return view('superadmin.medicines.form', compact('categories', 'types', 'units', 'storages', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'storage_id' => 'required|exists:storages,id',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'type_id' => 'required|exists:types,id',
            'unit_id' => 'required|exists:units,id',
            'category_id' => 'required|exists:categories,id',
            'expired_date' => 'required|date',
            'description' => 'nullable|string',
            'purchase_price' => 'required|integer|min:0',
            'selling_price' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        Medicine::create($validated);

        return redirect()->route('superadmin.medicines.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    public function edit(Medicine $medicine)
    {
        $categories = Category::all();
        $types = Type::all();
        $units = Unit::all();
        $storages = Storage::all();
        $suppliers = Supplier::all();
        
        return view('superadmin.medicines.form', compact('medicine', 'categories', 'types', 'units', 'storages', 'suppliers'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'storage_id' => 'required|exists:storages,id',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'type_id' => 'required|exists:types,id',
            'unit_id' => 'required|exists:units,id',
            'category_id' => 'required|exists:categories,id',
            'expired_date' => 'required|date',
            'description' => 'nullable|string',
            'purchase_price' => 'required|integer|min:0',
            'selling_price' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $medicine->update($validated);

        return redirect()->route('superadmin.medicines.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('superadmin.medicines.index')->with('success', 'Data obat berhasil dihapus!');
    }
}
