<?php

namespace App\Filament\Pages;

use App\Models\Department;
use Filament\Pages\Page;

class Calender extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.calender';

    public array $departments; 
    public ?string $selectedDepartment = null; 

    public function mount()
    {
        $this->departments = Department::pluck('name', 'department_code')->toArray();

        $this->selectedDepartment = array_key_first($this->departments) ?: null;
    }
}
