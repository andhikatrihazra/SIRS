<x-filament-panels::page>
    <x-filament::input.wrapper>
        <x-filament::input.select wire:model.live="selectedDepartment">
            @foreach($departments as $id => $title)
                <option value="{{ $id }}">{{ $title }}</option>
            @endforeach
        </x-filament::input.select>
    </x-filament::input.wrapper>

    @livewire(\App\Livewire\CalendarWidget::class, 
        ['selectedDepartment' => $selectedDepartment],
        key(str()->random())
    )
</x-filament-panels::page>
