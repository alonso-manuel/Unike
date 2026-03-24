<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GarantiaController;

/*
|--------------------------------------------------------------------------
| GARANTÍAS
|--------------------------------------------------------------------------
*/
Route::get('/garantia/creategarantia', [GarantiaController::class, 'create'])->name('creategarantia');
Route::get('/garantias/{date}', [GarantiaController::class, 'index'])->name('garantias');
Route::post('/garantia/insertgarantia', [GarantiaController::class, 'insertGarantia'])->name('insertgarantia');
