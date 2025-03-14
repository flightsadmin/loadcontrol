<?php

use App\Livewire\Inventory\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/database', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    return redirect()->back()->with('success', 'Database migrated and seeded successfully!');
})->name('migrate');

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/terminal', \App\Livewire\Terminal\Terminal::class)->name('terminal');
    Route::get('/products', \App\Livewire\Product\ProductManager::class)->name('products.manage');
    Route::get('/products/barcodes', \App\Livewire\Product\BarcodeGenerator::class)->name('products.barcodes');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
