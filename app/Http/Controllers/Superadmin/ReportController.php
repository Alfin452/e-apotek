<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Medicine;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function profit(Request $request)
    {
        // Get last 6 months of data
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }

        $labels = [];
        $revenueData = [];
        $profitData = [];
        $tableData = [];

        foreach ($months as $month) {
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

            // Get sales for this month
            $sales = Sale::with('details.medicine')->whereBetween('sale_date', [$startDate, $endDate])->get();
            
            $revenue = $sales->sum('grand_total');
            $cogs = 0; // Cost of Goods Sold

            foreach ($sales as $sale) {
                foreach ($sale->details as $detail) {
                    // Cogs is based on purchase price (or a fixed historical purchase price. For now we use current purchase_price)
                    $cogs += $detail->medicine->purchase_price * $detail->quantity;
                }
            }

            $profit = $revenue - $cogs;

            $monthName = $startDate->translatedFormat('F Y');
            $labels[] = $monthName;
            $revenueData[] = $revenue;
            $profitData[] = $profit;

            // Prepend so latest month is on top in table
            array_unshift($tableData, [
                'month_name' => $monthName,
                'revenue' => $revenue,
                'cogs' => $cogs,
                'profit' => $profit
            ]);
        }

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.profit', compact('tableData'));
            return $pdf->stream('laporan_laba_rugi.pdf');
        }

        return view('superadmin.reports.profit', compact('labels', 'revenueData', 'profitData', 'tableData'));
    }

    public function profitableMedicines(Request $request) 
    {
        // Calculate profit per medicine from sales
        // Profit = (selling_price - purchase_price) * qty
        // For accurate historical data, we should join sale_details and medicines.
        // For simplicity, we use current medicine purchase_price/selling_price from the relation if not recorded in detail.
        
        $medicinesProfit = DB::table('sale_details')
            ->join('medicines', 'sale_details.medicine_id', '=', 'medicines.id')
            ->select(
                'medicines.name',
                DB::raw('SUM(sale_details.quantity) as total_qty'),
                DB::raw('SUM(sale_details.subtotal) as total_revenue'),
                DB::raw('SUM(medicines.purchase_price * sale_details.quantity) as total_cogs')
            )
            ->groupBy('medicines.id', 'medicines.name')
            ->get();

        $tableData = [];
        $labels = [];
        $profitData = [];

        foreach ($medicinesProfit as $mp) {
            $profit = $mp->total_revenue - $mp->total_cogs;
            $tableData[] = [
                'name' => $mp->name,
                'qty' => $mp->total_qty,
                'revenue' => $mp->total_revenue,
                'profit' => $profit
            ];
        }

        // Sort by profit descending
        usort($tableData, function($a, $b) {
            return $b['profit'] <=> $a['profit'];
        });

        // Top 10 for chart
        $top10 = array_slice($tableData, 0, 10);
        foreach ($top10 as $t) {
            $labels[] = $t['name'];
            $profitData[] = $t['profit'];
        }

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.profitable_medicines', compact('tableData'));
            return $pdf->stream('laporan_obat_paling_menguntungkan.pdf');
        }

        return view('superadmin.reports.profitable_medicines', compact('labels', 'profitData', 'tableData'));
    }
    public function salesTrend(Request $request) 
    {
        // 30 days trend
        $days = [];
        $labels = [];
        $salesData = [];
        $tableData = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $days[] = $date;
            $labels[] = Carbon::parse($date)->translatedFormat('d M');
        }

        $sales = Sale::whereBetween('sale_date', [Carbon::now()->subDays(29)->startOfDay(), Carbon::now()->endOfDay()])
            ->select(DB::raw('DATE(sale_date) as date'), DB::raw('COUNT(*) as total_trx'), DB::raw('SUM(grand_total) as revenue'))
            ->groupBy('date')
            ->get()
            ->keyBy('date');

        foreach ($days as $date) {
            $trx = $sales->has($date) ? $sales[$date]->total_trx : 0;
            $rev = $sales->has($date) ? $sales[$date]->revenue : 0;
            $salesData[] = $trx;
            
            array_unshift($tableData, [
                'date' => Carbon::parse($date)->translatedFormat('d F Y'),
                'trx' => $trx,
                'revenue' => $rev
            ]);
        }

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.sales_trend', compact('tableData'));
            return $pdf->stream('laporan_tren_penjualan.pdf');
        }

        return view('superadmin.reports.sales_trend', compact('labels', 'salesData', 'tableData'));
    }

    public function categoryPerformance(Request $request) 
    {
        $categories = DB::table('sale_details')
            ->join('medicines', 'sale_details.medicine_id', '=', 'medicines.id')
            ->join('categories', 'medicines.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(sale_details.subtotal) as total_revenue'), DB::raw('SUM(sale_details.quantity) as total_qty'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->get();

        $labels = $categories->pluck('name')->toArray();
        $revenueData = $categories->pluck('total_revenue')->toArray();
        $tableData = $categories->toArray();

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.category_performance', compact('tableData'));
            return $pdf->stream('laporan_kinerja_kategori.pdf');
        }

        return view('superadmin.reports.category_performance', compact('labels', 'revenueData', 'tableData'));
    }

    public function cashierPerformance(Request $request) 
    {
        $cashiers = DB::table('sales')
            ->join('users', 'sales.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('COUNT(sales.id) as total_trx'), DB::raw('SUM(sales.grand_total) as total_revenue'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_revenue')
            ->get();

        $labels = $cashiers->pluck('name')->toArray();
        $revenueData = $cashiers->pluck('total_revenue')->toArray();
        $tableData = $cashiers->toArray();

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.cashier_performance', compact('tableData'));
            return $pdf->stream('laporan_kinerja_kasir.pdf');
        }

        return view('superadmin.reports.cashier_performance', compact('labels', 'revenueData', 'tableData'));
    }

    public function supplierSpending(Request $request) 
    {
        $suppliers = DB::table('purchases')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->select('suppliers.name', DB::raw('COUNT(purchases.id) as total_trx'), DB::raw('SUM(purchases.grand_total) as total_spending'))
            ->groupBy('suppliers.id', 'suppliers.name')
            ->orderByDesc('total_spending')
            ->get();

        $labels = $suppliers->pluck('name')->toArray();
        $spendingData = $suppliers->pluck('total_spending')->toArray();
        $tableData = $suppliers->toArray();

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.supplier_spending', compact('tableData'));
            return $pdf->stream('laporan_pemasok.pdf');
        }

        return view('superadmin.reports.supplier_spending', compact('labels', 'spendingData', 'tableData'));
    }

    public function expiredRisk(Request $request) 
    {
        $today = Carbon::now();
        $thirtyDays = Carbon::now()->addDays(30);
        $sixtyDays = Carbon::now()->addDays(60);

        // Group into Critical (< 30), Warning (< 60), Safe (Others)
        $medicines = Medicine::get();

        $critical = [];
        $warning = [];
        
        $criticalValue = 0;
        $warningValue = 0;

        foreach ($medicines as $med) {
            if (!$med->expired_date) continue;
            
            $expDate = Carbon::parse($med->expired_date);
            if ($expDate->lte($thirtyDays)) {
                $critical[] = $med;
                $criticalValue += ($med->stock * $med->purchase_price);
            } elseif ($expDate->lte($sixtyDays)) {
                $warning[] = $med;
                $warningValue += ($med->stock * $med->purchase_price);
            }
        }

        $labels = ['Kritis (< 30 Hari)', 'Waspada (< 60 Hari)'];
        $riskData = [$criticalValue, $warningValue];

        $tableData = [
            'critical' => $critical,
            'warning' => $warning,
            'criticalValue' => $criticalValue,
            'warningValue' => $warningValue
        ];

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.expired_risk', compact('tableData'));
            return $pdf->stream('laporan_risiko_kadaluarsa.pdf');
        }

        return view('superadmin.reports.expired_risk', compact('labels', 'riskData', 'tableData'));
    }

    public function stockStatus(Request $request) 
    {
        $criticalStocks = Medicine::whereColumn('stock', '<=', 'min_stock')->get();
            
        $safeStocks = Medicine::whereColumn('stock', '>', 'min_stock')->count();
            
        $labels = ['Stok Kritis', 'Stok Aman'];
        $stockData = [$criticalStocks->count(), $safeStocks];

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.stock_status', compact('criticalStocks'));
            return $pdf->stream('laporan_status_stok.pdf');
        }

        return view('superadmin.reports.stock_status', compact('labels', 'stockData', 'criticalStocks'));
    }

    public function cashflow(Request $request) 
    {
        // 6 months cashflow
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('Y-m');
        }

        $labels = [];
        $salesData = [];
        $purchasesData = [];
        $tableData = [];

        foreach ($months as $month) {
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

            $salesTotal = Sale::whereBetween('sale_date', [$startDate, $endDate])->sum('grand_total');
            $purchasesTotal = DB::table('purchases')->whereBetween('purchase_date', [$startDate, $endDate])->sum('grand_total');
            
            $monthName = $startDate->translatedFormat('F Y');
            $labels[] = $monthName;
            $salesData[] = $salesTotal;
            $purchasesData[] = $purchasesTotal;

            array_unshift($tableData, [
                'month_name' => $monthName,
                'sales' => $salesTotal,
                'purchases' => $purchasesTotal,
                'net' => $salesTotal - $purchasesTotal
            ]);
        }

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.cashflow', compact('tableData'));
            return $pdf->stream('laporan_arus_kas.pdf');
        }

        return view('superadmin.reports.cashflow', compact('labels', 'salesData', 'purchasesData', 'tableData'));
    }

    public function topSelling(Request $request) 
    {
        $medicines = DB::table('sale_details')
            ->join('medicines', 'sale_details.medicine_id', '=', 'medicines.id')
            ->select('medicines.name', DB::raw('SUM(sale_details.quantity) as total_qty'), DB::raw('SUM(sale_details.subtotal) as total_revenue'))
            ->groupBy('medicines.id', 'medicines.name')
            ->orderByDesc('total_qty')
            ->take(15)
            ->get();

        $labels = $medicines->pluck('name')->toArray();
        $qtyData = $medicines->pluck('total_qty')->toArray();
        $tableData = $medicines->toArray();

        if ($request->has('export') && $request->export == 'pdf') {
            $pdf = Pdf::loadView('superadmin.reports.pdf.top_selling', compact('tableData'));
            return $pdf->stream('laporan_obat_terlaris.pdf');
        }

        return view('superadmin.reports.top_selling', compact('labels', 'qtyData', 'tableData'));
    }
}
