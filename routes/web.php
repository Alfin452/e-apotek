<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (in_array(auth()->user()->role, ['superadmin', 'apoteker', 'kasir'])) {
        return redirect()->route('superadmin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:superadmin,apoteker,kasir'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard');
    
    // Apoteker & Superadmin routes
    Route::middleware('role:superadmin,apoteker')->group(function () {
        Route::get('medicines/expired', [\App\Http\Controllers\MedicineController::class, 'expired'])->name('medicines.expired');
        Route::get('medicines/out-of-stock', [\App\Http\Controllers\MedicineController::class, 'outOfStock'])->name('medicines.out_of_stock');
        Route::resource('medicines', \App\Http\Controllers\MedicineController::class);
        
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('units', \App\Http\Controllers\UnitController::class)->except(['create', 'show', 'edit']);
        Route::resource('suppliers', \App\Http\Controllers\SupplierController::class)->except(['create', 'show', 'edit']);
        
        Route::get('/purchases/chart', [\App\Http\Controllers\PurchaseController::class, 'chart'])->name('purchases.chart');
        Route::resource('purchases', \App\Http\Controllers\PurchaseController::class)->except(['edit', 'update', 'show']);
    });
    
    // Kasir & Superadmin routes
    Route::middleware('role:superadmin,kasir')->group(function () {
        Route::get('/sales/chart', [\App\Http\Controllers\SaleController::class, 'chart'])->name('sales.chart');
        Route::resource('sales', \App\Http\Controllers\SaleController::class);
    });

    // Reports routes (mixed access, mostly superadmin & apoteker)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::middleware('role:superadmin')->group(function () {
            Route::get('/profit', [\App\Http\Controllers\Superadmin\ReportController::class, 'profit'])->name('profit');
            Route::get('/sales-trend', [\App\Http\Controllers\Superadmin\ReportController::class, 'salesTrend'])->name('sales_trend');
            Route::get('/category-performance', [\App\Http\Controllers\Superadmin\ReportController::class, 'categoryPerformance'])->name('category_performance');
            Route::get('/cashier-performance', [\App\Http\Controllers\Superadmin\ReportController::class, 'cashierPerformance'])->name('cashier_performance');
            Route::get('/supplier-spending', [\App\Http\Controllers\Superadmin\ReportController::class, 'supplierSpending'])->name('supplier_spending');
            Route::get('/cashflow', [\App\Http\Controllers\Superadmin\ReportController::class, 'cashflow'])->name('cashflow');
        });

        Route::middleware('role:superadmin,apoteker')->group(function () {
            Route::get('/profitable-medicines', [\App\Http\Controllers\Superadmin\ReportController::class, 'profitableMedicines'])->name('profitable_medicines');
            Route::get('/expired-risk', [\App\Http\Controllers\Superadmin\ReportController::class, 'expiredRisk'])->name('expired_risk');
            Route::get('/stock-status', [\App\Http\Controllers\Superadmin\ReportController::class, 'stockStatus'])->name('stock_status');
            Route::get('/top-selling', [\App\Http\Controllers\Superadmin\ReportController::class, 'topSelling'])->name('top_selling');
        });
    });
});

require __DIR__.'/auth.php';
