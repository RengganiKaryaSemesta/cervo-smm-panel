@props(['x_model' => 'pagination.search'])
<div class="">
    <label for="filter-deleted" class="block text-gray-600 mb-2">Filter by Deleted</label>
    <select id="filter-deleted" class="form-select" wire:model.live="pagination.filters_by_deleted">
        <option value="">All</option>
        <option value="deleted">Deleted</option>
        <option value="not_deleted">Not Deleted</option>
    </select>
</div>
