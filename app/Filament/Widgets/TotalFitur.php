<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Doctor;
use App\Models\Room;
use App\Models\Department;

class TotalFitur extends BaseWidget
{

    protected static ?int $sort = 2;
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Dokter', Doctor::count())
                ->description('Total dokter yang terdaftar')
                // ->color('blue')
                ->chart([7,3,4,2,3,1,1,]),

            Stat::make('Jumlah Room', Room::count())
                ->description('Total room yang tersedia')
                        //    ->color('danger')
                                ->chart([7,3,4,2,9,1,1,2]),

            Stat::make('Jumlah Department', Department::count())
                ->description('Total departemen yang terdaftar')
                        //    ->color('danger')
                                                ->chart([7,3,4,2,9,1,1,2,9,9,]),
        ];
    }
}
