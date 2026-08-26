<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Medicine;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function chart(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $purchases = Purchase::selectRaw('MONTH(purchase_date) as month, SUM(grand_total) as total, COUNT(id) as transaction_count')
            ->whereYear('purchase_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        $chartData = array_fill(1, 12, 0);
        foreach ($purchases as $purchase) {
            $chartData[$purchase->month] = $purchase->total;
        }

        $highestRevenue = $purchases->max('total') ?? 0;
        $lowestRevenue = $purchases->where('total', '>', 0)->min('total') ?? 0;
        $highestSales = $purchases->max('transaction_count') ?? 0;
        $lowestSales = $purchases->where('transaction_count', '>', 0)->min('transaction_count') ?? 0;

        $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $stats = [
            'highest_revenue' => [
                'value' => $highestRevenue,
                'month' => $highestRevenue > 0 ? $months[$purchases->where('total', $highestRevenue)->first()->month] : '-'
            ],
            'lowest_revenue' => [
                'value' => $lowestRevenue,
                'month' => $lowestRevenue > 0 ? $months[$purchases->where('total', $lowestRevenue)->first()->month] : '-'
            ],
            'highest_sales' => [
                'value' => $highestSales,
                'month' => $highestSales > 0 ? $months[$purchases->where('transaction_count', $highestSales)->first()->month] : '-'
            ],
            'lowest_sales' => [
                'value' => $lowestSales,
                'month' => $lowestSales > 0 ? $months[$purchases->where('transaction_count', $lowestSales)->first()->month] : '-'
            ]
        ];
        
        $topMedicines = \App\Models\PurchaseDetail::selectRaw('medicines.name, SUM(purchase_details.quantity) as total_qty')
            ->join('purchases', 'purchases.id', '=', 'purchase_details.purchase_id')
            ->join('medicines', 'medicines.id', '=', 'purchase_details.medicine_id')
            ->whereYear('purchases.purchase_date', $year)
            ->groupBy('purchase_details.medicine_id', 'medicines.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();
        
        $availableYears = Purchase::selectRaw('YEAR(purchase_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
            
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        } else if (!in_array(date('Y'), $availableYears)) {
            array_unshift($availableYears, date('Y'));
        }
        
        return view('superadmin.purchases.chart', compact('chartData', 'year', 'availableYears', 'stats', 'topMedicines'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Purchase::with(['supplier', 'details.medicine.unit'])->orderBy('purchase_date', 'desc')->orderBy('id', 'desc');
        
        if ($search) {
            $query->whereHas('supplier', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
        
        $purchases = $query->paginate(10)->withQueryString();
        
        return view('superadmin.purchases.index', compact('purchases', 'search'));
    }

    public function create()
    {
        $medicines = Medicine::with('unit')->orderBy('name', 'asc')->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();
            
        return view('superadmin.purchases.create', compact('medicines', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'medicines' => 'required|array|min:1',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            $purchaseDetailsData = [];

            foreach ($request->medicines as $item) {
                $medicine = Medicine::lockForUpdate()->findOrFail($item['id']);
                
                $subtotal = $medicine->purchase_price * $item['quantity'];
                $grandTotal += $subtotal;

                // Tambah stok
                $medicine->stock += $item['quantity'];
                $medicine->save();

                $purchaseDetailsData[] = [
                    'medicine_id' => $medicine->id,
                    'quantity' => $item['quantity'],
                    'price' => $medicine->purchase_price,
                    'subtotal' => $subtotal,
                ];
            }

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'subtotal' => $grandTotal,
                'grand_total' => $grandTotal
            ]);

            foreach ($purchaseDetailsData as $detail) {
                $purchase->details()->create($detail);
            }

            DB::commit();

            return redirect()->route('superadmin.purchases.index')->with('success', 'Transaksi pembelian (Restock) berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function destroy(Purchase $purchase)
    {
        try {
            DB::beginTransaction();
            
            foreach ($purchase->details as $detail) {
                $medicine = Medicine::withTrashed()->find($detail->medicine_id);
                if ($medicine) {
                    $medicine->stock -= $detail->quantity;
                    $medicine->save();
                }
            }
            
            $purchase->delete();
            
            DB::commit();
            return redirect()->route('superadmin.purchases.index')->with('success', 'Data pembelian dihapus dan stok telah ditarik kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
