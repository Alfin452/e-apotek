<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function chart(Request $request)
    {
        $year = $request->input('year', date('Y'));
        
        $sales = Sale::selectRaw('MONTH(sale_date) as month, SUM(grand_total) as total, COUNT(id) as transaction_count')
            ->whereYear('sale_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Map to an array of 12 months initialized to 0
        $chartData = array_fill(1, 12, 0);
        foreach ($sales as $sale) {
            $chartData[$sale->month] = $sale->total;
        }

        // Calculate Stats
        $highestRevenue = $sales->max('total') ?? 0;
        $lowestRevenue = $sales->where('total', '>', 0)->min('total') ?? 0;
        $highestSales = $sales->max('transaction_count') ?? 0;
        $lowestSales = $sales->where('transaction_count', '>', 0)->min('transaction_count') ?? 0;

        $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $stats = [
            'highest_revenue' => [
                'value' => $highestRevenue,
                'month' => $highestRevenue > 0 ? $months[$sales->where('total', $highestRevenue)->first()->month] : '-'
            ],
            'lowest_revenue' => [
                'value' => $lowestRevenue,
                'month' => $lowestRevenue > 0 ? $months[$sales->where('total', $lowestRevenue)->first()->month] : '-'
            ],
            'highest_sales' => [
                'value' => $highestSales,
                'month' => $highestSales > 0 ? $months[$sales->where('transaction_count', $highestSales)->first()->month] : '-'
            ],
            'lowest_sales' => [
                'value' => $lowestSales,
                'month' => $lowestSales > 0 ? $months[$sales->where('transaction_count', $lowestSales)->first()->month] : '-'
            ]
        ];
        
        // Top 5 Medicines for the year
        $topMedicines = \App\Models\SaleDetail::selectRaw('medicines.name, SUM(sale_details.quantity) as total_qty')
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->join('medicines', 'medicines.id', '=', 'sale_details.medicine_id')
            ->whereYear('sales.sale_date', $year)
            ->groupBy('sale_details.medicine_id', 'medicines.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();
        
        // Available years for dropdown
        $availableYears = Sale::selectRaw('YEAR(sale_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
            
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        } else if (!in_array(date('Y'), $availableYears)) {
            array_unshift($availableYears, date('Y'));
        }
        
        return view('superadmin.sales.chart', compact('chartData', 'year', 'availableYears', 'stats', 'topMedicines'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Sale::with(['user', 'details.medicine.unit'])->orderBy('sale_date', 'desc')->orderBy('id', 'desc');
        
        if ($search) {
            $query->where('customer_name', 'like', "%{$search}%");
        }
        
        $sales = $query->paginate(10)->withQueryString();
        
        return view('superadmin.sales.index', compact('sales', 'search'));
    }

    public function create()
    {
        // Get all medicines with stock > 0, include unit relation for UI
        $medicines = Medicine::with('unit')
            ->where('stock', '>', 0)
            ->orderBy('name', 'asc')
            ->get();
            
        return view('superadmin.sales.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'sale_date' => 'required|date',
            'customer_cash' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'medicines' => 'required|array|min:1',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            $saleDetailsData = [];

            // 1. Validasi Stok & Kalkulasi
            foreach ($request->medicines as $item) {
                $medicine = Medicine::lockForUpdate()->findOrFail($item['id']);
                
                if ($medicine->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk obat: {$medicine->name}. Sisa stok: {$medicine->stock}");
                }

                $subtotal = $medicine->selling_price * $item['quantity'];
                $grandTotal += $subtotal;

                // Kurangi stok
                $medicine->stock -= $item['quantity'];
                $medicine->save();

                // Siapkan data detail
                $saleDetailsData[] = [
                    'medicine_id' => $medicine->id,
                    'quantity' => $item['quantity'],
                    'selling_price' => $medicine->selling_price,
                    'subtotal' => $subtotal,
                ];
            }

            // 2. Buat Transaksi Induk
            $sale = Sale::create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'sale_date' => $request->sale_date,
                'grand_total' => $grandTotal,
                'cash_given' => $request->customer_cash,
                'change' => max(0, $request->customer_cash - $grandTotal),
                'notes' => $request->notes,
                'user_id' => Auth::id()
            ]);

            // 3. Masukkan Detail Transaksi
            foreach ($saleDetailsData as $detail) {
                $sale->details()->create($detail);
            }

            DB::commit();

            return redirect()->route('superadmin.sales.index')->with('success', 'Transaksi penjualan berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['details.medicine.unit', 'user']);
        return view('superadmin.sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        // Rollback stok sebelum dihapus (Opsional, tergantung kebijakan apotek)
        try {
            DB::beginTransaction();
            
            foreach ($sale->details as $detail) {
                $medicine = Medicine::withTrashed()->find($detail->medicine_id);
                if ($medicine) {
                    $medicine->stock += $detail->quantity;
                    $medicine->save();
                }
            }
            
            $sale->delete();
            
            DB::commit();
            return redirect()->route('superadmin.sales.index')->with('success', 'Data penjualan dihapus dan stok telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
