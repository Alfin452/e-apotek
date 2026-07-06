<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Medicine;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Quick Stats
        $todayRevenue = Sale::whereDate('sale_date', $today)->sum('grand_total');
        $todaySalesCount = Sale::whereDate('sale_date', $today)->count();
        $todayPurchases = Purchase::whereDate('purchase_date', $today)->sum('grand_total');

        // Low Stock Medicines (Critical)
        // Ensure only items where stock is <= min_stock, limit to 5
        $lowStockMedicines = Medicine::whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // Activity Feed (Combine Sales and Purchases)
        $recentSales = Sale::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($sale) {
                return (object) [
                    'type' => 'sale',
                    'title' => 'Transaksi #' . str_pad($sale->id, 5, '0', STR_PAD_LEFT) . ' berhasil',
                    'description' => 'Kasir: ' . ($sale->user->name ?? 'Sistem') . ' • ' . $sale->created_at->diffForHumans(),
                    'created_at' => $sale->created_at,
                    'amount' => $sale->grand_total
                ];
            });

        $recentPurchases = Purchase::with('supplier')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($purchase) {
                return (object) [
                    'type' => 'purchase',
                    'title' => 'Restock Barang: ' . ($purchase->supplier->name ?? 'Pemasok'),
                    'description' => 'Senilai Rp ' . number_format($purchase->grand_total, 0, ',', '.') . ' • ' . $purchase->created_at->diffForHumans(),
                    'created_at' => $purchase->created_at,
                    'amount' => $purchase->grand_total
                ];
            });

        // Merge, sort by created_at desc, and take top 5
        $activities = $recentSales->concat($recentPurchases)->sortByDesc('created_at')->take(5);

        return view('superadmin.dashboard', compact(
            'todayRevenue',
            'todaySalesCount',
            'todayPurchases',
            'lowStockMedicines',
            'activities'
        ));
    }
}
