<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguracionController;

/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN - WEB
|--------------------------------------------------------------------------
*/
Route::prefix('configuracion')->group(function () {
    Route::prefix('web')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'web'])->name('configweb');
        Route::post('/updatecorreos', [ConfiguracionController::class, 'updateCorreos'])->name('updatecorreos');
        Route::post('/updatecuentasbancarias', [ConfiguracionController::class, 'updateCuentasBancarias'])->name('updatecuentasbancarias');
    });

    /*
    |--------------------------------------------------------------------------
    | CONFIGURACIÓN - CÁLCULOS
    |--------------------------------------------------------------------------
    */
    Route::prefix('calculos')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'calculos'])->name('configcalculos');
        Route::post('/updatecalculos', [ConfiguracionController::class, 'updateCalculos'])->name('updatecalculos');
        Route::post('/updateCalculosTasaFija', [ConfiguracionController::class, 'updateCalculosTasaFija'])->name('updateCalculosTasaFija');
        Route::post('/updatecomision', [ConfiguracionController::class, 'updateComision'])->name('updatecomision');
        Route::post('/createcomisionplataforma', [ConfiguracionController::class, 'createComisionPlataforma'])->name('createcomisionplataforma');
        Route::post('/deletecomisionplataforma', [ConfiguracionController::class, 'deleteComisionPlataforma'])->name('deletecomisionplataforma');
        Route::post('/tipo-cambio', [ConfiguracionController::class, 'cambiarTipoCambio'])->name('configuracion.tipoCambio');
    });

    /*
    |--------------------------------------------------------------------------
    | CONFIGURACIÓN - PRODUCTOS
    |--------------------------------------------------------------------------
    */
    Route::prefix('productos')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'productos'])->name('configproductos');
        Route::post('/insertmarca', [ConfiguracionController::class, 'createMarcaProducto'])->name('insertmarca');
        Route::post('/insertgrupo', [ConfiguracionController::class, 'createGrupoProducto'])->name('insertgrupo');
    });

    /*
    |--------------------------------------------------------------------------
    | CONFIGURACIÓN - ESPECIFICACIONES
    |--------------------------------------------------------------------------
    */
    Route::prefix('especificaciones')->group(function () {
        Route::get('/xgeneral', [ConfiguracionController::class, 'especificacionesGeneral'])->name('configespecificacionesgeneral');
        Route::get('/{idCategoria}', [ConfiguracionController::class, 'especificaciones'])->name('configespecificaciones');
        Route::get('/xgrupo/{idCategoria}', [ConfiguracionController::class, 'especificacionesGrupo'])->name('configespecificacionesxgrupo');
        Route::post('/insertcaracteristicaxgrupo', [ConfiguracionController::class, 'insertCaracteristicaXGrupo'])->name('insertcaracteristicaxgrupo');
        Route::post('/deletecaracteristicaxgrupo', [ConfiguracionController::class, 'deleteCaracteristicaXGrupo'])->name('deletecaracteristicaxgrupo');
        Route::post('/createcaracteristica', [ConfiguracionController::class, 'createCaracteristica'])->name('createcaracteristica');
        Route::post('/updatecaracteristica', [ConfiguracionController::class, 'updateCaracteristica'])->name('updatecaracteristica');
        Route::post('/removesugerencia', [ConfiguracionController::class, 'removeSugerencia'])->name('removesugerencia');
    });

    /*
    |--------------------------------------------------------------------------
    | CONFIGURACIÓN - INVENTARIO
    |--------------------------------------------------------------------------
    */
    Route::prefix('inventario')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'inventario'])->name('configinventario');
        Route::post('/createalamcen', [ConfiguracionController::class, 'createAlmacen'])->name('createalmacen');
        Route::post('/createproveedor', [ConfiguracionController::class, 'createProveedor'])->name('createproveedor');
    });
});
