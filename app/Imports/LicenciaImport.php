<?php

namespace App\Imports;

use App\Models\Licencia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LicenciaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Licencia([            
            'voucher_code' => $row['voucher_code'],
            'orden_compra' => $row['orden_compra'],
            'id_tipo'      => $row['id_tipo'],
            'idProveedor'  => $row['id_proveedor'],
            'estado'       => 'NUEVA'
        ]);
    }
}
