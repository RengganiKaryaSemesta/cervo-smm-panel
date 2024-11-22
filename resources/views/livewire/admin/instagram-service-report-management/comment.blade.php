<div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle mb-2">
                <div class="flex justify-between flex-col gap-2 md:flex-row items-center">
                    <div>
                    </div>
                    <x-our-table-input-search x_model="filters.search" />
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label for="startDate" class="block text-gray-600 mb-2 uppercase">Start Date</label>
                        <input type="date" class="form-input" wire:model.live="filters.startDate" id="startDate">
                    </div>
                    <div>
                        <label for="endDate" class="block text-gray-600 mb-2 uppercase">end Date</label>
                        <input type="date" class="form-input" wire:model.live="filters.endDate" id="endDate">
                    </div>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th>Started At</x-our-table-th>
                            <x-our-table-th>Finised At</x-our-table-th>
                            <x-our-table-th>Url</x-our-table-th>
                            <x-our-table-th>Number of Account</x-our-table-th>
                            <x-our-table-th>Total Completed</x-our-table-th>
                            <x-our-table-th>Total Failed</x-our-table-th>
                            <x-our-table-th>Status</x-our-table-th>
                            <x-our-table-th>Detail</x-our-table-th>
                        </tr>
                    </x-slot>
                    @forelse ($data as $item)
                        <tr>
                            <x-our-table-td>{{ $item->started_at?->format('H:i:s, j F Y') }}</x-our-table-td>
                            <x-our-table-td>{{ $item->finished_at?->format('H:i:s, j F Y') }}</x-our-table-td>
                            <x-our-table-td>{{ $item->url }}</x-our-table-td>
                            <x-our-table-td>{{ $item->account_count }}</x-our-table-td>
                            <x-our-table-td>{{ $item->total_completed }}</x-our-table-td>
                            <x-our-table-td>{{ $item->total_failed }}</x-our-table-td>
                            <x-our-table-td>
                                <x-badge-status cssClass="{{ $item->status->cssClass() }} ">
                                    {{ $item->status->label() }}
                                </x-badge-status>
                            </x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                <a
                                    href="{{ route('admin.reports.instagrams.detail', ['instagramService' => $item->id]) }}">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                            </x-our-table-td>
                        </tr>
                    @empty
                        <tr>
                            <x-our-table-td colspan="8" class=" text-center">
                                <p class="text-center w-full">Data not found!</p>
                            </x-our-table-td>
                        </tr>
                    @endforelse
                </x-our-table>
            </div>
            {{ $data->links() }}
        </div>
    </div>
</div>
