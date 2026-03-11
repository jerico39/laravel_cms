<x-filament::page>

<form wire:submit.prevent="save">

    {{ $this->form }}

    <x-filament::button type="submit">
        保存
    </x-filament::button>

</form>

</x-filament::page>
