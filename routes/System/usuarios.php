<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| USUARIOS
|--------------------------------------------------------------------------
*/
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('usuarios');
    Route::get('/nuevo', [UsuarioController::class, 'create'])->name('nuevousuario');
    Route::post('/createuser', [UsuarioController::class, 'createUser'])->name('createuser');
    Route::post('/updatepass', [UsuarioController::class, 'updatePass'])->name('updatepass');
    Route::post('/updatebandeja', [UsuarioController::class, 'updateBandeja'])->name('updatebandeja');
    Route::post('/updateuser', [UsuarioController::class, 'updateUser'])->name('updateuser');
});
