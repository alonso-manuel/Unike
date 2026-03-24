<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicidadController;
use App\Http\Controllers\PublicacionController;

/*
|--------------------------------------------------------------------------
| PUBLICIDAD / WEB
|--------------------------------------------------------------------------
*/
Route::get('/web', [PublicidadController::class, 'index'])->name('publicidad');
Route::get('/web/empresa/{idEmpresa}', [PublicidadController::class, 'empresa'])->name('empresa-publicidad');
Route::post('/web/updatepublicacion', [PublicidadController::class, 'updatePublicaion'])->name('updatepublicacion');

/*
|--------------------------------------------------------------------------
| PUBLICACIONES
|--------------------------------------------------------------------------
*/
Route::get('/registro-publicaciones/{date}', [PublicacionController::class, 'index'])->name('publicaciones');
Route::get('/crear-publicacion/{idPlataforma}', [PublicacionController::class, 'create'])->name('createpublicacion');
Route::post('/insert-publicacion', [PublicacionController::class, 'insertPublicacion'])->name('insertpublicacion');
Route::post('/update-estado-publicacion', [PublicacionController::class, 'updateEstado'])->name('update-estado-publicacion');
Route::get('/searchpublicacion', [PublicacionController::class, 'searchPublicacion'])->name('searchpublicacion');
