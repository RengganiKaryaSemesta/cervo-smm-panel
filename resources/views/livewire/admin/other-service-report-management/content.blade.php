<div>
    <x-loading />
    <div class="grid md:grid-cols-3 mb-5 gap-2">
        @foreach ($balances as $item)
        <x-widget-statistic color="info" title="{{$item->name}}" total="{{ $item->service_currency_code. $item->balance}}" progressbar="0"
            increase_from_last_month_in_percent="0" />
        @endforeach
    </div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle mb-2" x-data="initTable">
                <div class="grid grid-cols-2 mb-2 gap-2 md:grid-cols-4">
                    <div class="">
                        <label for="filters_status" class="block text-gray-600 mb-2">Filter by Status</label>
                        <select id="filters_status" class="form-select" wire:model.live="pagination.filters_status">
                            <option value="">All</option>
                            <option value="Completed">Completed</option>                           
                            <option value="In progres">In progres</option>                           
                            <option value="Partial">Partial</option>                           
                            <option value="Pending">Pending</option>                           
                            <option value="Failed">Failed</option>                           
                        </select>
                    </div>
                    <div>
                        <label for="startDate" class="block text-gray-600 mb-2 capitalize">Start Date</label>
                        <input type="date" class="form-input" wire:model.live="pagination.startDate" id="startDate">
                    </div>
                    <div>
                        <label for="endDate" class="block text-gray-600 mb-2 capitalize">end Date</label>
                        <input type="date" class="form-input" wire:model.live="pagination.endDate" id="endDate">
                    </div>
                    <x-our-table-input-search x_model="pagination.search" />
                </div>
                
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th orderColumnName="created_at" :pagination="$pagination">Date</x-our-table-th>
                            <x-our-table-th orderColumnName="creator.name" :pagination="$pagination">Creator</x-our-table-th>
                            <x-our-table-th orderColumnName="order_id" :pagination="$pagination">Order ID</x-our-table-th>
                            <x-our-table-th orderColumnName="service" :pagination="$pagination">Service</x-our-table-th>
                            <x-our-table-th orderColumnName="charge" :pagination="$pagination">Charge</x-our-table-th>
                            <x-our-table-th orderColumnName="target" :pagination="$pagination">Target</x-our-table-th>
                            <x-our-table-th orderColumnName="start_count" :pagination="$pagination">Start Count</x-our-table-th>
                            <x-our-table-th orderColumnName="remains" :pagination="$pagination">Remains</x-our-table-th>
                            <x-our-table-th orderColumnName="status" :pagination="$pagination">Status</x-our-table-th>
                        </tr>
                    </x-slot>
                    @forelse ($data as $item)
                        <tr>
                            <x-our-table-td>{{ $item->created_at?->format('j F Y') }}</x-our-table-td>
                            <x-our-table-td>{{ $item->creator?->name }}</x-our-table-td>
                            <x-our-table-td>{{ $item->order_id }}</x-our-table-td>
                            <x-our-table-td>{{ $item->service }}</x-our-table-td>
                            <x-our-table-td>{{ $item->smmProvider->service_currency_code }}{{ $item->charge }}</x-our-table-td>
                            <x-our-table-td>{{ $item->target }}</x-our-table-td>
                            <x-our-table-td> {{ $item->start_count }}</x-our-table-td>
                            <x-our-table-td>{{ $item->remains }}</x-our-table-td>
                            <x-our-table-td>{{ $item->status }}</x-our-table-td>
                        </tr>
                    @empty
                        <tr>
                            <x-our-table-td colspan="9" class=" text-center">
                                <div class="text-center w-full">Data not found</div>
                            </x-our-table-td>
                        </tr>
                    @endforelse
                </x-our-table>
            </div>
            {{ $data->links() }}
        </div>
    </div>

</div>
