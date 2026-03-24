<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrasladoController;

/*
|--------------------------------------------------------------------------
| TRASLADOS
|--------------------------------------------------------------------------
*/
Route::get('/traslado', [TrasladoController::class, 'index'])->name('traslados');
Route::post('/traslado/updateregistroalmacen', [TrasladoController::class, 'updateRegistroAlmacen'])->name('updateregistroalmacen');
