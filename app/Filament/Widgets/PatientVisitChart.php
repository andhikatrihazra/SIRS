<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class PatientVisitChart extends ChartWidget
{
    protected static ?string $heading = 'Patient Visit Chart';

        protected static ?int $sort = 3;


    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        // Ambil data jumlah registrasi per tanggal (registration_date)
        $data = Registration::select(
            DB::raw('DATE(registration_date) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Buat label dan dataset untuk chart
        $labels = $data->pluck('date')->map(function ($date) {
            return date('d M Y', strtotime($date));
        })->toArray();

        $counts = $data->pluck('count')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pendaftaran',
                    'data' => $counts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }
}

