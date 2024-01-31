<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            1 => new AssetsImport(),
            0 => new ReportsImport(),
        ];
    }

}
