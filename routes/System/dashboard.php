<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalculadoraController;

/*
|--------------------------------------------------------------------------
| DASHBOARD & HOME
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/stockmin', [HomeController::class, 'stockMinDashboard'])->name('stockmindashboard');
    Route::get('/inventario/{estado}', [HomeController::class, 'dashboardInventario'])->name('dashboardinventario');
});

/*
|--------------------------------------------------------------------------
| CALCULADORA
|--------------------------------------------------------------------------
*/
Route::prefix('calculadora')->group(function () {
    Route::get('/', [CalculadoraController::class, 'index'])->name('calculadora');
    Route::get('/calculate', [CalculadoraController::class, 'calculate'])->name('calculadora-calculate');
});
