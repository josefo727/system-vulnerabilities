<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Str;

class ReportsChart extends ChartWidget
{
    protected static ?string $heading = 'Reportes';

	protected static ?int $sort = 1;

    protected function getData(): array
    {
        $end = Carbon::today();
        $start = $end->copy()->subYear()->addMonth()->startOfMonth();

        $period = CarbonPeriod::create($start, '1 month', $end);

        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $monthName = Str::ucfirst($date->isoFormat('MMM-YY'));
            $labels[] = $monthName;

            $monthStart = $date->startOfMonth()->toDateString();
            $monthEnd = $date->endOfMonth()->toDateString();

            $count = Report::query()->whereBetween('detected_at', [$monthStart, $monthEnd])->count();
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Reportes creados',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(255, 99, 71, 0.2)',
                        'rgba(144, 238, 144, 0.2)',
                        'rgba(255, 228, 181, 0.2)',
                        'rgba(224, 255, 255, 0.2)',
                        'rgba(240, 128, 128, 0.2)'
                    ],
                    'borderColor'=> [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(255, 99, 71)',
                        'rgb(144, 238, 144)',
                        'rgb(255, 228, 181)',
                        'rgb(224, 255, 255)',
                        'rgb(240, 128, 128)'
                    ],
                    'borderWidth' => 1
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
