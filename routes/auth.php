<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ScriptController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin middleware de sesión)
|--------------------------------------------------------------------------
*/
Route::withoutMiddleware(['validate.session'])->group(function () {
    // Login
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'validation'])->name('validation');

    // Scripts JS
    Route::get('/js/header-scripts.js', [ScriptController::class, 'headerScript'])->name('js.header-scripts');
    Route::get('/js/calculator-scripts.js', [ScriptController::class, 'calculatorScript'])->name('js.calculator-scripts');
    Route::get('/js/documento-scripts.js/{idDocumento}', [ScriptController::class, 'documentoScript'])->name('js.documento-scripts');
    Route::get('/js/product-create-scripts.js/{tc}', [ScriptController::class, 'createProductScript'])->name('js.create-product-scripts');
    Route::get('/js/product-update-scripts.js/{tc}/{tcFijo}', [ScriptController::class, 'updateProductScript'])->name('js.update-product-scripts');
    Route::get('/js/product-list-scripts.js/{tc}', [ScriptController::class, 'listProductScript'])->name('js.list-product-scripts');
    Route::get('/js/config-calculos.js', [ScriptController::class, 'configCalculosScript'])->name('js.config-calculos.js');
});
