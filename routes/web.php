<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\RegistrationController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/cargos/{cargo}/update-hold', [CargoController::class, 'updateHold'])->name('cargos.update-hold');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/', FlightController::class);
    Route::resource('cargos', CargoController::class);
    Route::resource('flights', FlightController::class);
    Route::resource('registrations', RegistrationController::class);
    Route::resource('registrations.holds', HoldController::class)->shallow();
    Route::resource('flights.cargos', CargoController::class)->shallow();
    Route::resource('flights.passengers', PassengerController::class)->shallow();
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');