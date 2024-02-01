<?php

namespace App\Filament\Resources\ReportsResource\Widgets;

use Filament\Widgets\ChartWidget;

class ReportsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
