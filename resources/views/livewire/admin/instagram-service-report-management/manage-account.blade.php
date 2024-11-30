<div>
    <div class="grid md:grid-cols-3 mb-5 gap-2">
        <x-widget-statistic color="info" title="Total Account" total="{{ $data->total() }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
        <x-widget-statistic color="info" title="Total Account Active" total="{{ $totals->Active }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
        <x-widget-statistic color="info" title="Total Account Inactive" total="{{ $totals->Inactive }}"
            progressbar="0" increase_from_last_month_in_percent="0" />
    </div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle mb-2" x-data="initTable">
                <div class="flex justify-between flex-col gap-2 md:flex-row items-center">
                    <div>

                    </div>
                    <x-our-table-input-search />
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
                    <div>
                        <label for="creator" class="block text-gray-600 mb-2 uppercase">Creator</label>
                        <select name="creator" id="creator" wire:model.live="filters.creator" class="form-select">
                            <option value="" selected>Default</option>
                            @foreach ($creator as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-gray-600 mb-2 uppercase">Status</label>
                        <select name="status" id="status" wire:model.live="filters.status" class="form-select">
                            <option value="" selected>Default</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th orderColumnName="username" :pagination="$pagination">Username</x-our-table-th>
                            <x-our-table-th orderColumnName="email" :pagination="$pagination">Email</x-our-table-th>
                            <x-our-table-th orderColumnName="password" :pagination="$pagination">Password</x-our-table-th>
                            <x-our-table-th orderColumnName="status" :pagination="$pagination">Status</x-our-table-th>
                            <x-our-table-th orderColumnName="updated_at" :pagination="$pagination">Updated At</x-our-table-th>
                            <x-our-table-th orderColumnName="creator.name" :pagination="$pagination">Creator</x-our-table-th>
                        </tr>
                    </x-slot>
                    @forelse ($data as $item)
                        <tr>
                            <x-our-table-td>{{ $item->username }}</x-our-table-td>
                            <x-our-table-td>{{ $item->email }}</x-our-table-td>
                            <x-our-table-td>{{ $item->password }}</x-our-table-td>
                            <x-our-table-td>{{ $item->status ? 'Active' : 'Inactive' }}</x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                {{ $item->updated_at?->format('H:i, j F Y') }}
                            </x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                {{ $item->creator?->name }}
                            </x-our-table-td>
                        </tr>
                    @empty
                        <tr>
                            <x-our-table-td colspan="5" class=" text-center">
                                <p class="text-center w-full">Account Instagram not found!</p>
                            </x-our-table-td>
                        </tr>
                    @endforelse
                </x-our-table>
            </div>
            {{ $data->links() }}
        </div>
    </div>

    @script
        <script>
            Alpine.data('initTable', () => ({
                archive(id, type = 'Delete') {
                    Swal.fire({
                        title: `${type} User`,
                        text: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false,
                        preConfirm: async () => {
                            await $wire.delete(id);
                        }
                    })
                },
                init() {
                    $wire.on('swal:error', ({
                        message
                    }) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: message,
                        })
                    })
                    $wire.on('swal:success', ({
                        message
                    }) => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: message,
                        })
                    })
                }
            }))
        </script>
    @endscript
</div>
