<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LicenciaController;

/*
|--------------------------------------------------------------------------
| LICENCIAS - OPERACIONES
|--------------------------------------------------------------------------
*/
Route::prefix('licencias')->group(function () {
    Route::get('/descargar/{id}', [LicenciaController::class, 'descargarLicencia'])->name('licencia.descargar');
    Route::get('/', [LicenciaController::class, 'index'])->name('licencias.index');
    Route::post('/tipos-licencia', [LicenciaController::class, 'storeTipoLicencia'])->name('tiposLicencia.store');
    Route::post('/confirmar-importacion', [LicenciaController::class, 'confirmarImportacion'])->name('licencias.confirmar.importacion');
    Route::get('/importar', [LicenciaController::class, 'vistaImportar'])->name('licencias.importar.vista');
    Route::post('/importar-excel', [LicenciaController::class, 'importarExcel'])->name('licencias.importar.excel');

    /*
    |--------------------------------------------------------------------------
    | LICENCIAS - VERIFICACIONES
    |--------------------------------------------------------------------------
    */
    Route::post('/verificar-serial-recuperada', function (Request $request) {
        $serial = $request->input('serial_recuperada');

        $existe = DB::table('licencias_recuperadas')
                    ->where('serial_recuperada', $serial)
                    ->exists();

        return response()->json(['existe' => $existe]);
    });

    Route::post('/verificar-clave-duplicada', function (Request $request) {
        $claveKey = $request->input('clave_key');

        $existe = DB::table('licencias_usadas')
                    ->where('clave_key', $claveKey)
                    ->exists();

        return response()->json([
            'existe' => $existe,
            'clave' => $claveKey
        ]);
    })->name('verificar.clave.duplicada');

    /*
    |--------------------------------------------------------------------------
    | LICENCIAS - CRUD COMPLETO
    |--------------------------------------------------------------------------
    */
    Route::prefix('gestion')->name('licencias.')->group(function () {
        Route::get('/', [LicenciaController::class, 'index'])->name('index');
        Route::get('/create', [LicenciaController::class, 'create'])->name('create');
        Route::post('/store', [LicenciaController::class, 'store'])->name('store');
        Route::get('/{serial}/estado/{nuevoEstado}', [LicenciaController::class, 'showFormularioEstado'])->name('showFormularioEstado');
        Route::post('/{serial}/cambiar-estado', [LicenciaController::class, 'cambiarEstado'])->name('cambiar_estado');
        Route::get('/plantilla-excel', [LicenciaController::class, 'descargarPlantilla'])->name('plantilla_excel');
        Route::get('/usadas', [LicenciaController::class, 'usadas'])->name('usadas');
        Route::get('/defectuosas', [LicenciaController::class, 'defectuosas'])->name('defectuosas');
        Route::get('/recuperadas', [LicenciaController::class, 'recuperadas'])->name('recuperadas');
    });
});
