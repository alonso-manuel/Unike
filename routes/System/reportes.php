<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

/*
|--------------------------------------------------------------------------
| PDF & REPORTES
|--------------------------------------------------------------------------
*/
Route::prefix('reportes')->group(function () {
    Route::get('/generateSerialPdf/{idDocumento}', [PdfController::class, 'generateSerialPdf'])->name('generarSeriesPdf');
    Route::get('/pdf/serialbyproduct/{idProducto}/{idAlmacen?}', [PdfController::class, 'seriesByProductPdf'])->name('seriesXProducto');
    Route::get('/pdf/producto-series/{idProducto}/{idAlmacen}', [PdfController::class, 'productoSeriesPdf'])->name('pdf.producto.series');
    Route::get('/stock/{idAlmacen}', [PdfController::class, 'reportStockPdf'])->name('reportealmacen');
    Route::get('/pdf/garantia/{idGarantia}', [PdfController::class, 'garantiaPdf'])->name('garantiaPdf');
});
