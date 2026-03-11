<?php

namespace App\Services\Licencias\Handlers;

use App\Models\Licencia;
interface CambioEstadoHandlerInterface
{
    public function handle(Licencia $licencia, array $datosForm): void;
}
