<div class="grid grid-cols-2 mb-2 gap-2 md:grid-cols-4">
    <div class="">
        <label for="filters_status" class="block text-gray-600 mb-2">Filter by Status</label>
        <select id="filters_status" class="form-select" wire:model.live="filters.filters_status">
            <option value="">All</option>
            @foreach ($statuses as $item)
                <option value="{{ $item->value }}">{{ $item->label() }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="startDate" class="block text-gray-600 mb-2 capitalize">Start Date</label>
        <input type="date" class="form-input" wire:model.live="filters.startDate" id="startDate">
    </div>
    <div>
        <label for="endDate" class="block text-gray-600 mb-2 capitalize">end Date</label>
        <input type="date" class="form-input" wire:model.live="filters.endDate" id="endDate">
    </div>
    <x-our-table-input-search x_model="filters.search" />
</div>
