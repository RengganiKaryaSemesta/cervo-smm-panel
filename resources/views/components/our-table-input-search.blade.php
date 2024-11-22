@props(['x_model'=>'pagination.search'])
<div class="flex items-center relative">
    <input type="search" wire:model.live="{{$x_model}}" x-on:keyup="$wire.resetPage()"
        class="form-input pe-8 ps-4 text-xs bg-[#0b194e]/30 border-transparent focus:border-transparent placeholder:opacity-60"
        placeholder="Search...">
</div>
