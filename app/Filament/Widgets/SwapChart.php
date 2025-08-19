<?php

namespace App\Filament\Widgets;

use App\Models\SwapHistory;
use Filament\Widgets\ChartWidget;

class SwapChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    // protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
       $swaps = SwapHistory::selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->limit(7)
        ->get();

        return[
            'datasets' => [
                [
                    'label' => 'Swaps',
                    'data' => $swaps->pluck('total')->toArray(),
                ]
            ],
            'labels' => $swaps->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
