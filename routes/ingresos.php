<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IngresoController;

/*
|--------------------------------------------------------------------------
| INGRESOS
|--------------------------------------------------------------------------
*/
Route::get('/ingresos/searchingresos', [IngresoController::class, 'searchIngreso'])->name('searchingresos');
Route::get('/ingresos/getoneingreso', [IngresoController::class, 'getOneIngreso'])->name('getoneingreso');
Route::get('/ingresos/{month}', [IngresoController::class, 'index'])->name('ingresos');
Route::post('/ingreso/deleteingreso', [IngresoController::class, 'deleteIngreso'])->name('deleteingreso');
Route::post('/ingreso/updateregistro', [IngresoController::class, 'updateRegistro'])->name('updateregistro');
Route::post('/ingreso/insertcomprobante', [IngresoController::class, 'insertComprobante'])->name('insertcomprobante');
Route::post('/ingreso/insertingreso/{comprobante}', [IngresoController::class, 'insertIngreso'])->name('insertingreso');
