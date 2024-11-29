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

                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th>Date</x-our-table-th>
                            <x-our-table-th>Creator</x-our-table-th>
                            <x-our-table-th>Order ID</x-our-table-th>
                            <x-our-table-th>Service</x-our-table-th>
                            <x-our-table-th>Charge</x-our-table-th>
                            <x-our-table-th>Target</x-our-table-th>
                            <x-our-table-th>Start Count</x-our-table-th>
                            <x-our-table-th>Remains</x-our-table-th>
                            <x-our-table-th>Status</x-our-table-th>
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
                            <x-our-table-td colspan="5" class=" text-center">
                                <div class="text-center w-full">Data not found, please wait a moment as the data is
                                    being
                                    processed <br>
                                    <div class="animate-spin inline-block w-5 h-5 border-[3px] border-current border-t-transparent text-warning rounded-full"
                                        role="status" aria-label="loading">
                                        <span class="sr-only">Loading...</span>
                                        </class>
                                    </div>
                            </x-our-table-td>
                        </tr>
                    @endforelse
                </x-our-table>
            </div>
            {{ $data->links() }}
        </div>
    </div>

</div>
