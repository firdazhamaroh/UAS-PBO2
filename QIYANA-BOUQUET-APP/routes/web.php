<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderHomepageController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/**
 * 
 * FRONTEND CONTROLLER
 * 
 */
Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/test', [FrontendController::class, 'test']);

Route::post('/store-order', [FrontendController::class, 'storeOrder'])->name('frontend.store-order');
Route::post('/update-transaction', [FrontendController::class, 'updateOrderStatus'])->name('frontend.update-order');

/**
 * 
 * ADMIN CONTROLLER
 * 
 */
Route::prefix('/dashboard')->middleware('auth', 'role:admin')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/edit-profile', [AdminController::class, 'editProfile'])->name('admin.edit-profile');

    // GROUP CONTROLLER
    Route::resource('/kategori-produk', ProductCategoryController::class);
    Route::resource('/produk', ProductController::class);
    Route::resource('/diskon', DiscountController::class);
    Route::resource('/transaksi', TransactionController::class);
    Route::resource('/manajemen-pelanggan', CustomerController::class);
    Route::resource('/slider-homepage', SliderHomepageController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
