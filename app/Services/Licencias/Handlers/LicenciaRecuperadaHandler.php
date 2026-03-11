<?php

namespace App\Services\Licencias\Handlers;

use App\Models\Licencia;
use App\Models\LicenciaRecuperada;
use App\Models\LicenciaDefectuosa;
class LicenciaRecuperadaHandler implements CambioEstadoHandlerInterface
{
    public function handle(Licencia $licencia, array $datosForm): void
    {
        LicenciaRecuperada::create([
            'serial_recuperada' => $licencia->voucher_code,
            'id_licencia'       => $licencia->id,
            ...$datosForm
        ]);

        LicenciaDefectuosa::where('clave_key', $datosForm['serial_defectuosa'])
            ->update(['estado' => 'RECUPERADA']);
    }
}
