<?php

namespace App\Services;

use App\Repositories\LicenciaRepositoryInterface;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LicenciaImport;
use Illuminate\Support\Facades\DB;
use App\Services\Licencias\Handlers\UsarLicenciaCompletaHandler;
use App\Services\Licencias\Handlers\UsarLicenciaParcialHandler;



class LicenciaService implements LicenciaServiceInterface
{
    protected $repo;

    public function __construct(LicenciaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Importar licencias desde un 4 Excel usando Maatwebsite Excel.
     *
     * @param mixed $archivo
     * @return void
     */
    public function importarDesdeExcel($archivo, array $datosFijos)
    {
        Excel::import(new LicenciaImport($datosFijos), $archivo);
    }
    /**
     * Obtener licencias en estado NUEVA.
     */
    public function getLicenciasNuevas()
    {
        return $this->repo->getByEstado('NUEVA');
    }
    public function getLicenciasNuevasQuery()
    {
        return $this->repo->getNuevasQuery();
    }
    /**
     * Crear una licencia en estado NUEVA.
     */
    public function crearLicencia(array $data)
    {
        $data['estado'] = 'NUEVA';
        return $this->repo->crear($data);
    }

    /**
     * Registrar una licencia (uso genérico).
     */
    public function registrar(array $data)
    {
        return $this->repo->crear($data);
    }
    /**
     * Importar licencias desde un array de datos.
     */
    public function importarDesdeArray(array $data)
    {
        return $this->repo->storeFromExcel($data);
    }
    /**
     * Cambiar el estado de una licencia y crear el registro correspondiente
     * en la tabla de destino según el nuevo estado.
     */
    // PRUEBA PARA IMPLEMENTAR A LICENCIAS UNA CATEGORIA
    //Verificar el Uso de la licencia

    //FIN DE PRUBAS NO SUBIR A PRODUCCION HASTA PROBARLO
    public function cambiarEstadoConFormulario(
        string $voucherCode,
        string $nuevoEstado,
        array $datosForm
    ) {
        return DB::transaction(function () use ($voucherCode, $nuevoEstado, $datosForm) {

            $licencia = $this->repo->findByCode($voucherCode);

            if ($nuevoEstado === 'USADA') {

                if ($licencia->esMultifuncional()) {

                    $modo = $datosForm['modo_uso'] ?? 'PARCIAL';

                    if ($modo === 'COMPLETO') {
                        app(UsarLicenciaCompletaHandler::class)
                            ->handle($licencia, $datosForm);
                    } else {
                        app(UsarLicenciaParcialHandler::class)
                            ->handle($licencia, $datosForm);
                    }

                    return $licencia;
                }

                // UNIFUNCIONAL
                app(\App\Services\Licencias\Handlers\LicenciaUsadaHandler::class)
                    ->handle($licencia, $datosForm);

                return $licencia;
            }

            // Otros estados
            $handler = match ($nuevoEstado) {
                'DEFECTUOSA' => app(\App\Services\Licencias\Handlers\LicenciaDefectuosaHandler::class),
                'RECUPERADA' => app(\App\Services\Licencias\Handlers\LicenciaRecuperadaHandler::class),
                default => throw new \InvalidArgumentException("Estado no soportado"),
            };

            $handler->handle($licencia, $datosForm);

            return $licencia;
        });
    }



    public function buscarLicenciaPorCodigo(string $voucherCode)
    {
        return $this->repo->findBySerial($voucherCode);
    }
}
