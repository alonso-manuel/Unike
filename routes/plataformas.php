<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlataformaController;

/*
|--------------------------------------------------------------------------
| PLATAFORMAS
|--------------------------------------------------------------------------
*/
Route::get('/plataformas', [PlataformaController::class, 'index'])->name('plataformas');
Route::post('/plataforma/updatecuenta', [PlataformaController::class, 'updateCuentas'])->name('updatecuenta');
Route::post('/plataforma/createcuenta', [PlataformaController::class, 'createCuenta'])->name('createcuenta');
