<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalculadoraController;

/*
|--------------------------------------------------------------------------
| DASHBOARD & HOME
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/dashboard/stockmin', [HomeController::class, 'stockMinDashboard'])->name('stockmindashboard');
Route::get('/dashboard/inventario/{estado}', [HomeController::class, 'dashboardInventario'])->name('dashboardinventario');

/*
|--------------------------------------------------------------------------
| CALCULADORA
|--------------------------------------------------------------------------
*/
Route::get('/calculadora', [CalculadoraController::class, 'index'])->name('calculadora');
Route::get('/calculadora/calculate', [CalculadoraController::class, 'calculate'])->name('calculadora-calculate');
