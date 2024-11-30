<div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle mb-2">
                <div class="flex justify-between flex-col gap-2 md:flex-row items-center">
                    <div>
                        <a wire:navigate class="btn bg-danger text-white" href="{{route('admin.reports.instagrams.'.$type)}}">Back</a>
                    </div>
                    <div class="flex gap-2">
                        <div class="">
                            <label for="filters_status" class="block text-gray-600 mb-2">Filter by Status</label>
                            <select id="filters_status" class="form-select" wire:model.live="pagination.filters_status">
                                <option value="">All</option>
                                @foreach ($statuses as $item)
                                    <option value="{{ $item->value }}">{{ $item->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-our-table-input-search />
                    </div>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th orderColumnName="instagramAccount.email" :pagination="$pagination">Instagram Account</x-our-table-th>
                            @if ($isComment)
                                <x-our-table-th orderColumnName="comment" :pagination="$pagination">Comment</x-our-table-th>
                            @endif
                            <x-our-table-th orderColumnName="status" :pagination="$pagination">Status</x-our-table-th>
                            <x-our-table-th orderColumnName="error_msg" :pagination="$pagination">Error Msg</x-our-table-th>
                        </tr>
                    </x-slot>
                    @forelse ($data as $item)
                        <tr>
                            <x-our-table-td>{{ $item->instagramAccount?->email }}</x-our-table-td>
                            @if ($isComment)
                                <x-our-table-td>{{ $item->comment }}</x-our-table-td>
                            @endif
                            <x-our-table-td>
                                <x-badge-status cssClass="{{ $item->status->cssClass() }} ">
                                    {{ $item->status->label() }}
                                </x-badge-status>
                            </x-our-table-td>
                            <x-our-table-td>{{ $item->error_msg }}</x-our-table-td>
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
