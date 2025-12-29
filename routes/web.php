<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Halaman depan toko (user)
Route::get('/', [ShopController::class, 'index'])->name('shop.index');

// Form beli produk
Route::get('/beli/{produk}', [ShopController::class, 'orderForm'])->name('shop.order.form');

// Proses pembelian
Route::post('/beli/{produk}', [ShopController::class, 'orderStore'])->name('shop.order.store');
