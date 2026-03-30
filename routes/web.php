<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');