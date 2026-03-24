<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| USUARIOS
|--------------------------------------------------------------------------
*/
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
Route::get('/usuario/nuevo', [UsuarioController::class, 'create'])->name('nuevousuario');
Route::post('/usuario/createuser', [UsuarioController::class, 'createUser'])->name('createuser');
Route::post('/usuario/updatepass', [UsuarioController::class, 'updatePass'])->name('updatepass');
Route::post('/usuario/updatebandeja', [UsuarioController::class, 'updateBandeja'])->name('updatebandeja');
Route::post('/usuario/updateuser', [UsuarioController::class, 'updateUser'])->name('updateuser');
