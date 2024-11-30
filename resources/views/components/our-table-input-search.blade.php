@props(['x_model'=>'pagination.search'])
<div class="">
    <label for="search" class="block text-gray-600 mb-2">Search</label>
    <input id="search" type="search" wire:model.live="{{$x_model}}" x-on:keyup="$wire.resetPage()"
        class="form-input"
        placeholder="Search...">
</div>
