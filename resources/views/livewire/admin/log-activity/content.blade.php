<div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle">
                <div
                    class="flex justify-end flex-col gap-2 md:flex-row items-center">
                    <x-our-table-input-search/>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th>User</x-our-table-th>
                            <x-our-table-th>Judul</x-our-table-th>
                            <x-our-table-th>Deskripsi</x-our-table-th>
                            <x-our-table-th>Tanggal</x-our-table-th>
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
