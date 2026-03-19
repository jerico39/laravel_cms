<x-filament::page>
@php
    $logo = $data['logo'] ?? null;

    if (is_array($logo)) {
        $logo = $logo[0] ?? null;
    }
@endphp
    <div class="flex justify-end mb-4">
        @if(!empty($logo))
            <img src="{{ Storage::url($logo) }}">
        @endif
    </div>

<form wire:submit.prevent="save">

    {{ $this->form }}

    <x-filament::button type="submit">
        保存
    </x-filament::button>

</form>

</x-filament::page>
