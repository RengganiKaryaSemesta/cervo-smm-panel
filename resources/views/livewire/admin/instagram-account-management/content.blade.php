<div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle mb-2" x-data="initTable">
                <div class="flex justify-between flex-wrap gap-2 flex-row md:items-end">
                    <div class="flex items-center gap-2 flex-wrap">
                        @can('create instagram account management')
                            <button wire:click="add" type="button" class="btn bg-primary ">Create Account</button>
                        @endcan
                        @if ($pagination['selecteds'])
                            @can('delete user management')
                                <button x-on:click="archive([])" type="button" class="btn bg-danger">Delete Data</button>
                                <button x-on:click="archive([],'Restore')" type="button" class="btn bg-warning">Restore
                                    Data</button>
                            @endcan
                        @endif
                    </div>
                    <div class="flex gap-2 items-center">
                        <div class="">
                            <label for="filters_status" class="block text-gray-600 mb-2">Filter by Status</label>
                            <select id="filters_status" class="form-select" wire:model.live="pagination.filters_status">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        @can('delete user management')
                            <x-our-table-filter-deleted />
                        @endcan
                        <x-our-table-input-search />
                    </div>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th class="w-10"><input type="checkbox" wire:model.live="pagination.selectAll"
                                    class="form-checkbox bg-primary"></x-our-table-th>
                            <x-our-table-th orderColumnName="username" :pagination="$pagination">Username</x-our-table-th>
                            <x-our-table-th orderColumnName="email" :pagination="$pagination">Email</x-our-table-th>
                            <x-our-table-th orderColumnName="password" :pagination="$pagination">Password</x-our-table-th>
                            <x-our-table-th orderColumnName="status" :pagination="$pagination">Status</x-our-table-th>
                            <x-our-table-th>Edit</x-our-table-th>
                            <x-our-table-th>Delete</x-our-table-th>
                        </tr>
                    </x-slot>
                    @forelse ($data as $item)
                        <tr>
                            <x-our-table-th class="w-10"><input type="checkbox" wire:model.live="pagination.selecteds"
                                    value="{{ $item->id }}" class="form-checkbox bg-primary"></x-our-table-th>
                            <x-our-table-td>{{ $item->username }}</x-our-table-td>
                            <x-our-table-td>{{ $item->email }}</x-our-table-td>
                            <x-our-table-td>{{ $item->password }}</x-our-table-td>
                            <x-our-table-td>{{ $item->status ? 'Active' : 'Inactive' }}</x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                @can('update instagram account management')
                                    @if ($item->deleted_at == null)
                                        <button wire:click="edit({{ $item->id }})"><i
                                                class="mdi mdi-pencil"></i></button>
                                    @endif
                                @endcan
                            </x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                @can('delete instagram account management')
                                    @if ($item->deleted_at == null)
                                        <button x-on:click="archive({{ $item->id }})">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    @elseif ($item->deleted_at !== null)
                                        <button x-on:click="archive({{ $item->id }},'Restore')">
                                            <i class="mdi mdi-backup-restore"></i>
                                        </button>
                                    @endif
                                @endcan
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
    <x-offcanvas title="{{ $formTitle }}">
        <livewire:admin.instagram-account-management.form />
    </x-offcanvas>

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
                            await $wire.delete(id, type);
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
