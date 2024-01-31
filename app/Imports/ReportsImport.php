<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\AssociatedVulnerability;
use App\Models\Network;
use App\Models\Report;
use App\Models\Source;
use App\Models\Vulnerability;
use App\Services\ConvertDateService;
use App\Services\DetermineCriticalityService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;



class ReportsImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Model|Builder
    {
        $source = Source::query()->firstOrCreate(
            ['name' => $row['fuente']]
        );

        $report = Report::query()->firstOrCreate(
            [
                'name' => $row['informe']
            ],
            [
                'source_id' => $source->id,
                'detected_at' => app(ConvertDateService::class)->handle($row['fecha_detectada'])
            ]
        );

        $vulnerability = Vulnerability::query()->firstOrCreate(
            [
                'name' => $row['vulnerabilidad']
            ],
            [
                'severity' => $string = Str::ucfirst(Str::lower($row['severidad_cvss'])),
                'details' => $this->sanitizeString($row['detalle_de_vulnerabilidad']),
                'solution' => $this->sanitizeString($row['solucion']),
            ]
        );

        $assetId = app(Asset::class)->getAssetIdByName($row['activo_de_informacion']);

        if (is_null($assetId)) {
            Log::info('Activo: ' . $row['activo_de_informacion']);
        }

        if (!!$assetId && !!$vulnerability && !!$report) {
            $associatedVulnerability = AssociatedVulnerability::query()->updateOrCreate(
                [
                    'asset_id' => $assetId,
                    'vulnerability_id' => $vulnerability->id,
                    'report_id' => $report->id,
                    'port' => $row['puerto'],
                ],
                [
                    'last_scan_at' => app(ConvertDateService::class)->handle($row['fecha_de_ultimo_escaneo']),
                    'comments' => $this->sanitizeString($row['comentarios']),
                ]
            );
        }

        return $report;
    }

    private function sanitizeString(null|string $string): string
    {
        if (is_null($string)) return '';

        $string = trim($string);

        $string = preg_replace('/\s+/', ' ', $string);

        return htmlspecialchars($string);
    }
}

