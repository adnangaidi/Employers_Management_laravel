<?php

namespace App\Filament\Resources\EmployeesResource\Widgets;

use App\Models\Country;
use App\Models\Employees;
use App\Models\State;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeesStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $gaza=State::where('name','gaza')->withCount('employees')->first();
        $mr=Country::where('country_code','mr')->withCount('employees')->first();
        return [
            Stat::make('All Countries', Country::all()->count()),
            Stat::make($gaza->name.' Employees', $gaza->employees_count),
            Stat::make($mr->name.' Employees', $mr->employees_count),
        ];
    }
}
