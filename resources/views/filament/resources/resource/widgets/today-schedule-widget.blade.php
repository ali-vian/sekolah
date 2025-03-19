
{{-- <x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">{{ $this->heading }}</x-slot>
        
        {{ $this->table }}
    </x-filament::section>
</x-filament::widget> --}}

<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">{{ $this->heading }}</x-slot>
        
        {{ $this->getTableContent() }}
    </x-filament::section>
</x-filament::widget>