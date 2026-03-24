<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EgresoController;

/*
|--------------------------------------------------------------------------
| EGRESOS
|--------------------------------------------------------------------------
*/
Route::get('/egresos/searchregistro', [EgresoController::class, 'searchRegistro'])->name('searchregistro');
Route::get('/egresos/searchegreso', [EgresoController::class, 'searchEgreso'])->name('searchegreso');
Route::get('/egresos/getoneegreso', [EgresoController::class, 'getOneRegistro'])->name('getoneegreso');
Route::get('/egresos/nuevosegresos', [EgresoController::class, 'create'])->name('createegreso');
Route::get('/egresos/total', [EgresoController::class, 'getTotalEgresos'])->name('egresos.total');
Route::get('/egresos/{month}', [EgresoController::class, 'index'])->name('egresos');
Route::post('/egresos/insertegreso', [EgresoController::class, 'insertEgreso'])->name('insertegreso');
Route::post('/egresos/devolucionegreso', [EgresoController::class, 'devolucionEgreso'])->name('devolucionegreso');
