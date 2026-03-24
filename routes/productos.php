<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| PRODUCTOS
|--------------------------------------------------------------------------
*/
Route::get('/productos/buscarproducto', [ProductoController::class, 'searchProduct'])->name('buscarproducto');
Route::get('/productos/searchmodelproduct', [ProductoController::class, 'searchModelProduct'])->name('searchmodelproduct');
Route::get('/producto/calculate', [ProductoController::class, 'calculate'])->name('calculateproducto');
Route::get('/productos/{cat}/{grup}', [ProductoController::class, 'index'])->name('productos');
Route::get('/producto/nuevoproducto', [ProductoController::class, 'create'])->name('createproducto');
Route::get('/producto/especificaciones/{idProducto}', [ProductoController::class, 'details'])->name('details');
Route::get('/producto/{idproducto}', [ProductoController::class, 'update'])->name('producto');
Route::post('/producto/createdetails', [ProductoController::class, 'createDetails'])->name('createdetails');
Route::post('/producto/updateproduct/{id}', [ProductoController::class, 'updateProduct'])->name('updateproduct');
Route::post('/producto/insertorupdatedetails', [ProductoController::class, 'insertOrUpdateDetails'])->name('insertorupdatedetails');
Route::post('/producto/deletedetail/{idProducto}', [ProductoController::class, 'deleteDetail'])->name('deletedetail');
