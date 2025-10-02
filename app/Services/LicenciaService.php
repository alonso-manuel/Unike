<?php

namespace App\Services;

use App\Repositories\LicenciaRepositoryInterface;
use App\Models\LicenciaUsada;
use App\Models\LicenciaDefectuosa;
use App\Models\LicenciaRecuperada;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LicenciaImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LicenciaService implements LicenciaServiceInterface
{
    protected $repo;

    public function __construct(LicenciaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Importar licencias desde un archivo Excel usando Maatwebsite Excel.
     *
     * @param mixed $archivo
     * @return void
     */
    public function importarDesdeExcel($archivo)
    {
        Excel::import(new LicenciaImport, $archivo);
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
    public function cambiarEstadoConFormulario(string $serial, string $nuevoEstado, array $datosForm)
    {          
        // Opcional: hacer todo en transacción
        return DB::transaction(function () use ($serial, $nuevoEstado, $datosForm) {

            // Cambiar el estado en la tabla principal
            $licencia = $this->repo->cambiarEstado($serial, $nuevoEstado, $datosForm);

            if (!$licencia) {
                throw new \Exception("La licencia con serial $serial no existe.");
            }

            // Insertar en la tabla correspondiente según el nuevo estado
            switch ($nuevoEstado) {
            case 'USADA':
                $archivo = null;
                
                if (!empty($datosForm['archivo']) && $datosForm['archivo'] instanceof \Illuminate\Http\UploadedFile) {
                    // Nombre base sin extensión
                    $nombreOriginal = pathinfo($datosForm['archivo']->getClientOriginalName(), PATHINFO_FILENAME);

                    // Extensión del archivo (ejemplo: rcf, bin, etc.)
                    $extension = $datosForm['archivo']->getClientOriginalExtension();

                    // Nombre único -> conserva nombre original + sufijo único
                    $nombreUnico = $nombreOriginal . '_' . uniqid() . '.' . $extension;

                    // Guardar en storage/app/public/licencias_usadas
                    $path = $datosForm['archivo']->storeAs('licencias_usadas', $nombreUnico, 'public');

                    // Se guarda en BD algo como: "licencias_usadas/EPSON_WF-C5890_64f9b8d7c9a3f.rcf"
                    $archivo = $path;
                }
                unset($datosForm['archivo']); // Eliminamos el archivo temporal

                LicenciaUsada::create([
                    'clave_key'   => $serial,
                    'id_licencia' => $licencia->id,
                    'archivo'     => $archivo,
                    ...$datosForm,
                ]);

                // Eliminar solo la recuperada seleccionada
                if (!empty($datosForm['idRecuperada'])) {
                    LicenciaRecuperada::where('id', $datosForm['idRecuperada'])->delete();
                }
                break;
                case 'DEFECTUOSA':
                    LicenciaDefectuosa::create(array_merge([
                        'clave_key'   => $serial,
                        'id_licencia' => $licencia->id
                    ], $datosForm));
                    
                    // Eliminar solo la recuperada seleccionada
                    if (!empty($datosForm['idRecuperada'])) {
                        LicenciaRecuperada::where('id', $datosForm['idRecuperada'])->delete();
                    }
                    break;
                case 'RECUPERADA':
                    // Insertar en recuperadas
                    LicenciaRecuperada::create(array_merge([
                        'serial_recuperada' => $serial,
                        'id_licencia' => $licencia->id
                    ], $datosForm));

                    // Actualizar la tabla defectuosas cambiando el estado
                    LicenciaDefectuosa::where('clave_key', $datosForm['serial_defectuosa'])
                        ->update(['estado' => 'RECUPERADA']);
                    break;

                default:
                    throw new \InvalidArgumentException("Estado no soportado: $nuevoEstado");
            }   

            return $licencia;
        });
    }

    public function buscarLicenciaPorCodigo(string $voucherCode)
    {
        return $this->repo->findBySerial($voucherCode);
    }
}
