<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| CLIENTES
|--------------------------------------------------------------------------
*/
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes');
    Route::get('/searchcliente', [ClienteController::class, 'searchCliente'])->name('searchcliente');
    Route::post('/create', [ClienteController::class, 'createCliente'])->name('createcliente');
});
