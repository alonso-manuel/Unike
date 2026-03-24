<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| CLIENTES
|--------------------------------------------------------------------------
*/
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes');
Route::get('/cliente/searchcliente', [ClienteController::class, 'searchCliente'])->name('searchcliente');
Route::post('/cliente/create', [ClienteController::class, 'createCliente'])->name('createcliente');
