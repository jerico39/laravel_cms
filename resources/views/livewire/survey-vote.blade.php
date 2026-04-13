<div>
    <input type="text" wire:model="option_text">

    @error('option_text')
        <div class="text-red-500">{{ $message }}</div>
    @enderror

    <button wire:click="addOption">追加</button>
</div>