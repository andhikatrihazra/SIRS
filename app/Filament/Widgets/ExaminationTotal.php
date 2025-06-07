<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Examination;

class ExaminationTotal extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Total Examination by Doctor';

    protected function getType(): string
    {
        return 'line'; // Line chart
    }

    protected function getData(): array
    {
        // Ambil data jumlah pemeriksaan per dokter, group by doctor_license_number
        $examinations = Examination::selectRaw('doctor_license_number, COUNT(*) as total')
            ->groupBy('doctor_license_number')
            ->with('doctor')
            ->get();

        // Siapkan label dan data
        $labels = [];
        $data = [];

        foreach ($examinations as $examination) {
            // Ambil nama dokter dari relasi, fallback 'Unknown Doctor'
            $labels[] = $examination->doctor ? $examination->doctor->name : 'Unknown Doctor';
            $data[] = $examination->total;
        }

        return [
            'labels' => $labels, // Label sumbu X (nama dokter)
            'datasets' => [
                [
                    'label' => 'Total Examinations',
                    'data' => $data, // Data sumbu Y (total pemeriksaan)
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'fill' => false, // Jangan fill area di bawah garis
                    'tension' => 0.4, // Smooth curve
                ],
            ],
        ];
    }
}
