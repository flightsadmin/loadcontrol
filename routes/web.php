<?php

use App\Http\Controllers\AircraftTypeController;
use App\Http\Controllers\CabinZoneController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EnvelopeController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\FuelFigureController;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\LoadsheetController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/database', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    return redirect()->back()->with('success', 'Database migrated and seeded successfully!');
})->name('migrate');

Route::group(['middleware' => ['auth']], function () {

    Route::resource('/', FlightController::class);
    Route::resource('cargos', CargoController::class);
    Route::resource('flights', FlightController::class);
    Route::resource('aircraft_types', AircraftTypeController::class);
    Route::resource('email_templates', EmailTemplateController::class);
    Route::resource('flights.loadsheets', LoadsheetController::class);
    Route::resource('flights.cargos', CargoController::class)->shallow();
    Route::resource('flights.passengers', PassengerController::class)->shallow();
    Route::resource('flights.fuel-figures', FuelFigureController::class)->shallow();
    Route::resource('aircraft_types.holds', HoldController::class)->shallow();
    Route::resource('aircraft_types.cabin_zones', CabinZoneController::class)->shallow();
    Route::resource('aircraft_types.envelopes', EnvelopeController::class)->shallow();
    Route::resource('aircraft_types.registrations', RegistrationController::class)->shallow();
    Route::post('/flights/{flight}/finalize', [LoadsheetController::class, 'finalizeLoadsheet'])->name('loadsheets.finalize');
    Route::get('/home', [FlightController::class, 'index'])->name('home');
    Route::get('/airlines', App\Livewire\Airlines::class)->name('airlines');
});

Route::group(['middleware' => ['auth', 'role:super-admin|admin']], function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Auth::routes();
