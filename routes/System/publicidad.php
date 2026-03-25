<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicidadController;
use App\Http\Controllers\PublicacionController;

/*
|--------------------------------------------------------------------------
| PUBLICIDAD / WEB
|--------------------------------------------------------------------------
*/
Route::prefix('web')->group(function () {
    Route::get('/', [PublicidadController::class, 'index'])->name('publicidad');
    Route::get('/empresa/{idEmpresa}', [PublicidadController::class, 'empresa'])->name('empresa-publicidad');
    Route::post('/updatepublicacion', [PublicidadController::class, 'updatePublicaion'])->name('updatepublicacion');
});

/*
|--------------------------------------------------------------------------
| PUBLICACIONES
|--------------------------------------------------------------------------
*/
Route::prefix('publicaciones')->group(function () {
    Route::get('/registro/{date}', [PublicacionController::class, 'index'])->name('publicaciones');
    Route::get('/crear/{idPlataforma}', [PublicacionController::class, 'create'])->name('createpublicacion');
    Route::post('/insert', [PublicacionController::class, 'insertPublicacion'])->name('insertpublicacion');
    Route::post('/update-estado', [PublicacionController::class, 'updateEstado'])->name('update-estado-publicacion');
    Route::get('/search', [PublicacionController::class, 'searchPublicacion'])->name('searchpublicacion');
});
