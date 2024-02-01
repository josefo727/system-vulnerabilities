<?php

namespace App\Filament\Widgets;

use App\Models\Status;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AssociatedVulnerabilitiesChart extends ChartWidget
{
    protected static ?string $heading = 'Vulnerabilidades asociadas';

	protected static ?int $sort = 2;

    // protected static ?string $maxHeight = '275px';

    protected function getData(): array
    {
        $end = Carbon::today();
        $start = $end->copy()->subYear()->addMonth()->startOfMonth();

        $statuses = Status::query()->withCount([
        "associatedVulnerabilities as vulnerabilities_count" => function (
            $query
        ) use ($start) {
            $query->where("last_scan_at", ">=", $start);
        }
        ])->get();

        $data = [];
        $labels = [];

        foreach ($statuses as $status) {
            $data[] = $status->vulnerabilities_count;
            $labels[] = $status->name;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 205, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(54, 162, 235)',
                        'rgba(153, 102, 25)',
                        'rgba(201, 203, 202)',
                        'rgba(255, 99, 71)',
                        'rgba(144, 238, 144)',
                        'rgba(255, 228, 181)',
                        'rgba(224, 255, 255)',
                        'rgba(240, 128, 128)'
                    ],
                    'hoverOffset' => 4
                ],
            ],
            'labels' => $labels,

        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
