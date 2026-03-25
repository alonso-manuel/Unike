<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlataformaController;

/*
|--------------------------------------------------------------------------
| PLATAFORMAS
|--------------------------------------------------------------------------
*/
Route::prefix('plataformas')->group(function () {
    Route::get('/', [PlataformaController::class, 'index'])->name('plataformas');
    Route::post('/updatecuenta', [PlataformaController::class, 'updateCuentas'])->name('updatecuenta');
    Route::post('/createcuenta', [PlataformaController::class, 'createCuenta'])->name('createcuenta');
});
