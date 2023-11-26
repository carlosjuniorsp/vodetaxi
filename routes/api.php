<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\RaceAcceptedController;
use App\Http\Controllers\StartRaceController;
use App\Http\Controllers\StatusDriverController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



/**
 * Client's Router
 */
Route::post('/clients', [ClientsController::class, 'store'])->name('store');
Route::get('/clients', [ClientsController::class, 'index'])->name('index');
Route::delete('/clients/{id}', [ClientsController::class, 'destroy'])->name('destroy');
Route::put('/clients/activation/{id}', [ClientsController::class, 'AccountActivation'])->name('AccountActivation');

/**
 * Driver Router
 */
Route::post('/driver', [DriverController::class, 'store'])->name('store');
Route::get('/driver', [DriverController::class, 'index'])->name('index');
Route::put('/driver/activation/{id}', [DriverController::class, 'AccountActivation'])->name('AccountActivation');
Route::delete('/driver/{id}', [DriverController::class, 'destroy'])->name('destroy');

/**
 * Cars Router
 */
Route::post('/cars/{id}', [CarsController::class, 'store'])->name('store');
Route::get('/cars', [CarsController::class, 'index'])->name('index');
Route::put('/cars/{id}', [CarsController::class, 'update'])->name('update');

/**
 * Status Driver Router
 */
Route::post('/status-driver/{id}', [StatusDriverController::class, 'store'])->name('store');
Route::get('/status-driver', [StatusDriverController::class, 'index'])->name('index');
Route::put('/status-driver/{id}', [StatusDriverController::class, 'update'])->name('update');

/**
 * Status Driver Router
 */
Route::post('/start-racer/{id}', [StartRaceController::class, 'StartRacer'])->name('StartRacer');

/**
 * Status Driver Router
 */
Route::post('/start-racer/{id}', [StartRaceController::class, 'StartRacer'])->name('StartRacer');

/**
 * Race accepted
 */
Route::get('/race-accepted/{id}', [RaceAcceptedController::class, 'AcceptedRacer'])->name('AcceptedRacer');
Route::put('/race-accepted/{id}/{running}', [RaceAcceptedController::class, 'update'])->name('update');