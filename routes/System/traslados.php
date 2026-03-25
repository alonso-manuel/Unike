<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrasladoController;

/*
|--------------------------------------------------------------------------
| TRASLADOS
|--------------------------------------------------------------------------
*/
Route::prefix('traslados')->group(function () {
    Route::get('/', [TrasladoController::class, 'index'])->name('traslados');
    Route::post('/updateregistroalmacen', [TrasladoController::class, 'updateRegistroAlmacen'])->name('updateregistroalmacen');
});
