<?php

use App\Livewire\Inventory\Dashboard;
use App\Livewire\Pos\Terminal;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/pos', Terminal::class)->name('pos.terminal');
    Route::get('/products', \App\Livewire\Product\ProductManager::class)->name('products.manage');
    Route::get('/products/barcodes', \App\Livewire\Product\BarcodeGenerator::class)->name('products.barcodes');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
