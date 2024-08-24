<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('cargos', CargoController::class);
    Route::resource('flights', FlightController::class);
    Route::resource('registrations', RegistrationController::class);
    Route::resource('registrations.holds', HoldController::class)->shallow();
    Route::resource('flights.cargos', CargoController::class)->shallow();
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');