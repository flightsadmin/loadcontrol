<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HoldController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnvelopeController;
use App\Http\Controllers\CabinZoneController;
use App\Http\Controllers\LoadsheetController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\FuelFigureController;
use App\Http\Controllers\AircraftTypeController;
use App\Http\Controllers\RegistrationController;

Route::get('/database', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    return redirect()->back()->with('success', 'Database migrated and seeded successfully!');
})->name('migrate.fresh.seed');
Route::get('import', [ImportController::class, 'showForm'])->name('import.form');
Route::post('import', [ImportController::class, 'import'])->name('import');


Route::group(['middleware' => ['auth', 'role:super-admin|admin']], function () {
    Route::resource('/', FlightController::class);
    Route::resource('cargos', CargoController::class);
    Route::resource('flights', FlightController::class);
    Route::resource('airlines', AirlineController::class);
    Route::resource('aircraft_types', AircraftTypeController::class);
    Route::resource('flights.loadsheets', LoadsheetController::class);
    Route::resource('flights.cargos', CargoController::class)->shallow();
    Route::resource('flights.passengers', PassengerController::class)->shallow();
    Route::resource('flights.fuel-figures', FuelFigureController::class)->shallow();
    Route::resource('aircraft_types.holds', HoldController::class)->shallow();
    Route::resource('aircraft_types.cabin_zones', CabinZoneController::class)->shallow();
    Route::resource('aircraft_types.envelopes', EnvelopeController::class)->shallow();
    Route::resource('aircraft_types.registrations', RegistrationController::class)->shallow();
    Route::post('/cargos/{cargo}/update-hold', [CargoController::class, 'updateHold'])->name('cargos.update-hold');
    Route::get('/home', [App\Http\Controllers\FlightController::class, 'index'])->name('home');

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Auth::routes();