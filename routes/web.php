<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/

// Product listing
Route::get('/products', [
    ProductController::class,
    'index'
])->name('products.index');


// Store product
Route::post('/products', [
    ProductController::class,
    'store'
])->name('products.store');


// Update product
Route::put('/products/{product}', [
    ProductController::class,
    'update'
])->name('products.update');


// Delete single product
Route::delete('/products/{product}', [
    ProductController::class,
    'destroy'
])->name('products.destroy');


// Bulk delete
Route::post('/products/bulk-delete', [
    ProductController::class,
    'bulkDelete'
])->name('products.bulkDelete');


// Export CSV
Route::get('/products/export/csv', [
    ProductController::class,
    'export'
])->name('products.export');