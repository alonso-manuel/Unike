<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GarantiaController;

/*
|--------------------------------------------------------------------------
| GARANTÍAS
|--------------------------------------------------------------------------
*/
Route::prefix('garantias')->group(function () {
    Route::get('/creategarantia', [GarantiaController::class, 'create'])->name('creategarantia');
    Route::get('/{date}', [GarantiaController::class, 'index'])->name('garantias');
    Route::post('/insertgarantia', [GarantiaController::class, 'insertGarantia'])->name('insertgarantia');
});
