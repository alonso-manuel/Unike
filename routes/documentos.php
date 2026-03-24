<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentoController;

/*
|--------------------------------------------------------------------------
| DOCUMENTOS
|--------------------------------------------------------------------------
*/
Route::get('/documento/searchdocument', [DocumentoController::class, 'searchDocument'])->name('searchdocument');
Route::get('/documento/validateseries', [DocumentoController::class, 'validateSeries'])->name('validate.series');
Route::get('/documento/{id}/{bool}', [DocumentoController::class, 'index'])->name('documento');
Route::get('/documentos/{date}', [DocumentoController::class, 'list'])->name('documentos');
Route::post('/documento/deletecomprobante', [DocumentoController::class, 'deleteComprobante'])->name('deletecomprobante');
