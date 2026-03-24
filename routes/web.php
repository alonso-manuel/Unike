<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin middleware de sesión)
|--------------------------------------------------------------------------
*/
Route::withoutMiddleware(['validate.session'])->group(function () {
    require __DIR__ . '/auth.php';
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Con middleware de sesión)
|--------------------------------------------------------------------------
*/
Route::middleware(['validate.session'])->group(function () {
    require __DIR__ . '/dashboard.php';
    require __DIR__ . '/usuarios.php';
    require __DIR__ . '/productos.php';
    require __DIR__ . '/ingresos.php';
    require __DIR__ . '/egresos.php';
    require __DIR__ . '/documentos.php';
    require __DIR__ . '/clientes.php';
    require __DIR__ . '/garantias.php';
    require __DIR__ . '/traslados.php';
    require __DIR__ . '/plataformas.php';
    require __DIR__ . '/publicidad.php';
    require __DIR__ . '/configuracion.php';
    require __DIR__ . '/reportes.php';
    require __DIR__ . '/licencias.php';
});
