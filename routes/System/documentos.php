<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentoController;

/*
|--------------------------------------------------------------------------
| DOCUMENTOS
|--------------------------------------------------------------------------
*/
Route::prefix('documentos')->group(function () {
    Route::get('/searchdocument', [DocumentoController::class, 'searchDocument'])->name('searchdocument');
    Route::get('/validateseries', [DocumentoController::class, 'validateSeries'])->name('validate.series');
    Route::get('/{id}/{bool}', [DocumentoController::class, 'index'])->name('documento');
    Route::get('/{date}', [DocumentoController::class, 'list'])->name('documentos');
    Route::post('/deletecomprobante', [DocumentoController::class, 'deleteComprobante'])->name('deletecomprobante');
});
