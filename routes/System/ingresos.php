<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngresoController;

/*
|--------------------------------------------------------------------------
| INGRESOS
|--------------------------------------------------------------------------
*/
Route::prefix('ingresos')->group(function () {
    Route::get('/searchingresos', [IngresoController::class, 'searchIngreso'])->name('searchingresos');
    Route::get('/getoneingreso', [IngresoController::class, 'getOneIngreso'])->name('getoneingreso');
    Route::get('/{month}', [IngresoController::class, 'index'])->name('ingresos');
    Route::post('/deleteingreso', [IngresoController::class, 'deleteIngreso'])->name('deleteingreso');
    Route::post('/updateregistro', [IngresoController::class, 'updateRegistro'])->name('updateregistro');
    Route::post('/insertcomprobante', [IngresoController::class, 'insertComprobante'])->name('insertcomprobante');
    Route::post('/insertingreso/{comprobante}', [IngresoController::class, 'insertIngreso'])->name('insertingreso');
});
