<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguracionController;

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN - WEB
|--------------------------------------------------------------------------
*/
Route::get('/configuracion/web', [ConfiguracionController::class, 'web'])->name('configweb');
Route::post('/configuracion/updatecorreos', [ConfiguracionController::class, 'updateCorreos'])->name('updatecorreos');
Route::post('/configuracion/updatecuentasbancarias', [ConfiguracionController::class, 'updateCuentasBancarias'])->name('updatecuentasbancarias');

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN - CÁLCULOS
|--------------------------------------------------------------------------
*/
Route::get('/configuracion/calculos', [ConfiguracionController::class, 'calculos'])->name('configcalculos');
Route::post('/configuracion/updatecalculos', [ConfiguracionController::class, 'updateCalculos'])->name('updatecalculos');
Route::post('/configuracion/updateCalculosTasaFija', [ConfiguracionController::class, 'updateCalculosTasaFija'])->name('updateCalculosTasaFija');
Route::post('/configuracion/updatecomision', [ConfiguracionController::class, 'updateComision'])->name('updatecomision');
Route::post('/configuracion/createcomisionplataforma', [ConfiguracionController::class, 'createComisionPlataforma'])->name('createcomisionplataforma');
Route::post('/configuracion/deletecomisionplataforma', [ConfiguracionController::class, 'deleteComisionPlataforma'])->name('deletecomisionplataforma');
Route::post('/configuracion/tipo-cambio', [ConfiguracionController::class, 'cambiarTipoCambio'])->name('configuracion.tipoCambio');

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN - PRODUCTOS
|--------------------------------------------------------------------------
*/
Route::get('/configuracion/productos', [ConfiguracionController::class, 'productos'])->name('configproductos');
Route::post('/configuracion/insertmarca', [ConfiguracionController::class, 'createMarcaProducto'])->name('insertmarca');
Route::post('/configuracion/insertgrupo', [ConfiguracionController::class, 'createGrupoProducto'])->name('insertgrupo');

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN - ESPECIFICACIONES
|--------------------------------------------------------------------------
*/
Route::get('/configuracion/especificacionesxgeneral', [ConfiguracionController::class, 'especificacionesGeneral'])->name('configespecificacionesgeneral');
Route::get('/configuracion/especificaciones/{idCategoria}', [ConfiguracionController::class, 'especificaciones'])->name('configespecificaciones');
Route::get('/configuracion/especificacionesxgrupo/{idCategoria}', [ConfiguracionController::class, 'especificacionesGrupo'])->name('configespecificacionesxgrupo');
Route::post('/configuracion/insertcaracteristicaxgrupo', [ConfiguracionController::class, 'insertCaracteristicaXGrupo'])->name('insertcaracteristicaxgrupo');
Route::post('/configuracion/deletecaracteristicaxgrupo', [ConfiguracionController::class, 'deleteCaracteristicaXGrupo'])->name('deletecaracteristicaxgrupo');
Route::post('/configuracion/createcaracteristica', [ConfiguracionController::class, 'createCaracteristica'])->name('createcaracteristica');
Route::post('/configuracion/updatecaracteristica', [ConfiguracionController::class, 'updateCaracteristica'])->name('updatecaracteristica');
Route::post('/configuracion/removesugerencia', [ConfiguracionController::class, 'removeSugerencia'])->name('removesugerencia');

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN - INVENTARIO
|--------------------------------------------------------------------------
*/
Route::get('/configuracion/inventario', [ConfiguracionController::class, 'inventario'])->name('configinventario');
Route::post('/configuracion/createalamcen', [ConfiguracionController::class, 'createAlmacen'])->name('createalmacen');
Route::post('/configuracion/createproveedor', [ConfiguracionController::class, 'createProveedor'])->name('createproveedor');
