<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillaLicenciaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([
            ['VOUCHER-001']
        ]);
    }

    public function headings(): array
    {
        return [
            'voucher_code'
        ];
    }
}
