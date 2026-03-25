<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin middleware de sesión)
|--------------------------------------------------------------------------
*/
Route::withoutMiddleware(['validate.session'])->group(function () {
    require __DIR__ . '/Auth/public.php';
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Con middleware de sesión)
|--------------------------------------------------------------------------
*/
Route::middleware(['validate.session'])->group(function () {
    // Dashboard & Home
    require __DIR__ . '/System/dashboard.php';
    
    // Módulos del Sistema
    require __DIR__ . '/System/usuarios.php';
    require __DIR__ . '/System/productos.php';
    require __DIR__ . '/System/ingresos.php';
    require __DIR__ . '/System/egresos.php';
    require __DIR__ . '/System/documentos.php';
    require __DIR__ . '/System/clientes.php';
    require __DIR__ . '/System/garantias.php';
    require __DIR__ . '/System/traslados.php';
    require __DIR__ . '/System/plataformas.php';
    require __DIR__ . '/System/publicidad.php';
    require __DIR__ . '/System/configuracion.php';
    require __DIR__ . '/System/reportes.php';
    require __DIR__ . '/System/licencias.php';
});
