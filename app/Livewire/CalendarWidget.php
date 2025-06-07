<?php

namespace App\Livewire;

use Filament\Widgets\Widget;
use App\Models\DoctorSchedule;
use App\Models\Doctor;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget; 
use Saade\FilamentFullCalendar\Data\EventData;

class CalendarWidget extends FullCalendarWidget
{
    public ?string $selectedDepartment = null; 

    protected $listeners = ['departmentChanged' => 'setDepartment'];

    public function setDepartment($departmentCode)
    {
        $this->selectedDepartment = $departmentCode;
    }

    protected function getViewData(): array
    {
        return [
            'selectedDepartment' => $this->selectedDepartment,
        ];
    }

    public function fetchEvents(array $info): array
    {
        // Query builder untuk jadwal dokter
        $schedulesQuery = DoctorSchedule::query()
            ->with(['doctor', 'department']);

        // Filter berdasarkan department jika dipilih
        if ($this->selectedDepartment) {
            $schedulesQuery->where('department_code', $this->selectedDepartment);
        }

        $schedules = $schedulesQuery->get();

        $events = [];
        $period = \Carbon\CarbonPeriod::create($info['start'], $info['end']);

        foreach ($period as $date) {
            foreach ($schedules as $schedule) {
                // Bandingkan hari dalam bahasa Inggris
                $dayName = strtolower($date->format('l')); // monday, tuesday, etc.
                $scheduleDay = strtolower($schedule->day);

                if ($dayName === $scheduleDay) {
                    $start = $date->copy()->setTimeFromTimeString($schedule->start_time);
                    $end = $date->copy()->setTimeFromTimeString($schedule->end_time);

                    $events[] = EventData::make()
                        ->id($schedule->id . '-' . $date->format('Ymd'))
                        ->title("Dr. {$schedule->doctor->name} ({$schedule->department->name})")
                        ->start($start)
                        ->end($end)
                        ->toArray();
                }
            }
        }

        return $events;
    }
}