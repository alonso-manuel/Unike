<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| PRODUCTOS
|--------------------------------------------------------------------------
*/
Route::prefix('productos')->group(function () {
    Route::get('/buscarproducto', [ProductoController::class, 'searchProduct'])->name('buscarproducto');
    Route::get('/searchmodelproduct', [ProductoController::class, 'searchModelProduct'])->name('searchmodelproduct');
    Route::get('/calculate', [ProductoController::class, 'calculate'])->name('calculateproducto');
    Route::get('/{cat}/{grup}', [ProductoController::class, 'index'])->name('productos');
    Route::get('/nuevoproducto', [ProductoController::class, 'create'])->name('createproducto');
    Route::get('/especificaciones/{idProducto}', [ProductoController::class, 'details'])->name('details');
    Route::get('/{idproducto}', [ProductoController::class, 'update'])->name('producto');
    Route::post('/createdetails', [ProductoController::class, 'createDetails'])->name('createdetails');
    Route::post('/updateproduct/{id}', [ProductoController::class, 'updateProduct'])->name('updateproduct');
    Route::post('/insertorupdatedetails', [ProductoController::class, 'insertOrUpdateDetails'])->name('insertorupdatedetails');
    Route::post('/deletedetail/{idProducto}', [ProductoController::class, 'deleteDetail'])->name('deletedetail');
});
