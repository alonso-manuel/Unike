<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EgresoController;

/*
|--------------------------------------------------------------------------
| EGRESOS
|--------------------------------------------------------------------------
*/
Route::prefix('egresos')->group(function () {
    Route::get('/searchregistro', [EgresoController::class, 'searchRegistro'])->name('searchregistro');
    Route::get('/searchegreso', [EgresoController::class, 'searchEgreso'])->name('searchegreso');
    Route::get('/getoneegreso', [EgresoController::class, 'getOneRegistro'])->name('getoneegreso');
    Route::get('/nuevosegresos', [EgresoController::class, 'create'])->name('createegreso');
    Route::get('/total', [EgresoController::class, 'getTotalEgresos'])->name('egresos.total');
    Route::get('/{month}', [EgresoController::class, 'index'])->name('egresos');
    Route::post('/insertegreso', [EgresoController::class, 'insertEgreso'])->name('insertegreso');
    Route::post('/devolucionegreso', [EgresoController::class, 'devolucionEgreso'])->name('devolucionegreso');
});
