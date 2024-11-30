<div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle">
                <div class="flex justify-between flex-col gap-2 md:flex-row items-center">
                    <div>
                        <button wire:click="delete" wire:confirm="Are you sure you want to delete this data?" class="btn bg-danger text-white">Delete for safety</button>
                    </div>
                    <x-our-table-input-search />
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th orderColumnName="causer.name" :pagination="$pagination">User</x-our-table-th>
                            <x-our-table-th orderColumnName="log_name" :pagination="$pagination">Judul</x-our-table-th>
                            <x-our-table-th orderColumnName="description" :pagination="$pagination">Deskripsi</x-our-table-th>
                            <x-our-table-th orderColumnName="created_at" :pagination="$pagination">Tanggal</x-our-table-th>
                        </tr>
                    </x-slot>
                    @foreach ($activities as $item)
                        <tr>
                            <x-our-table-td>
                                {{ $item->causer->name }}
                            </x-our-table-td>
                            <x-our-table-td>
                                {{ $item->log_name }}
                            </x-our-table-td>
                            <x-our-table-td>
                                {{ $item->description }}
                            </x-our-table-td>
                            <x-our-table-td>
                                {{ $item->created_at->format('j F Y, H:i') }}
                            </x-our-table-td>
                        </tr>
                    @endforeach
                    <x-slot name="pagination">
                        {{ $activities->links() }}
                    </x-slot>
                </x-our-table>
            </div>
        </div>
    </div>
</div>
