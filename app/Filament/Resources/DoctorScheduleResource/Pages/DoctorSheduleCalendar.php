<?php

namespace App\Filament\Resources\DoctorScheduleResource\Pages;

use App\Filament\Resources\DoctorScheduleResource;
use App\Models\Doctor;
use Filament\Resources\Pages\Page;

class DoctorSheduleCalendar extends Page
{
    protected static string $resource = DoctorScheduleResource::class;

    protected static string $view = 'filament.resources.doctor-schedule-resource.pages.doctor-shedule-calendar';

        protected static ?string $navigationIcon = 'heroicon-o-calendar';

    // protected static string $view = 'filament.pages.calendar';

    public array $tracks;

    public ?string $selectedTrack = null;

    public function mount()
    {
        $this->tracks = Doctor::pluck('name', 'id')->toArray();
        $this->selectedTrack = array_key_first($this->tracks);
    }
}
