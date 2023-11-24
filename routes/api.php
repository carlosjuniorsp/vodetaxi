<?php

use App\Http\Controllers\ClientsController;
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




Route::post('/clients',[ClientsController::class, 'store'])->name('store');
Route::get('/clients',[ClientsController::class, 'index'])->name('index');
Route::put('/clients/activation/{id}',[ClientsController::class, 'AccountActivation'])->name('AccountActivation');