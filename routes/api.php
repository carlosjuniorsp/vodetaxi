<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\CarsController;
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
