<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\Network;
use App\Services\DetermineCriticalityService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetsImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Model|Builder
    {
        return Asset::query()->updateOrCreate(
            [
                'name' => $row['activo_de_informacion'],
            ],
            [
                'ip_address' => $row['direccion_ip'],
                'description' => $row['descripcion'],
                'operating_system' => $row['so'],
                'type' => $row['tipo'],
                'criticality' => app(DetermineCriticalityService::class)->handle($row['criticidad_activo']),
                'network_id' => app(Network::class)->getNetworkIdByName($row['red']),
            ]
        );
    }

}

