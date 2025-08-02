<?php

namespace App\Filament\Widgets;

use App\Models\Operator;
use App\Models\SwapHistory;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Swaps Today', SwapHistory::whereDate('created_at', today())->count()),
            Stat::make('Total Users', User::count()),
            Stat::make('Total Operators', Operator::count())
        ];
    }
}