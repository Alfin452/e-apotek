<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('medicines/expired', [\App\Http\Controllers\MedicineController::class, 'expired'])->name('medicines.expired');
    Route::get('medicines/out-of-stock', [\App\Http\Controllers\MedicineController::class, 'outOfStock'])->name('medicines.out_of_stock');
    Route::resource('medicines', \App\Http\Controllers\MedicineController::class);
    
    // Category & Unit routes (Only index, store, update, destroy needed for single-page CRUD)
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('units', \App\Http\Controllers\UnitController::class)->except(['create', 'show', 'edit']);
});

require __DIR__.'/auth.php';
