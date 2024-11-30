<div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle mb-2" x-data="initTable">
                <div class="flex justify-between flex-col gap-2 md:flex-row md:items-end">
                    <div>
                        @can('create user management')
                            <button wire:click="add" type="button" class="btn bg-primary ">New Data</button>
                        @endcan
                        @if ($pagination['selecteds'])
                            @can('delete user management')
                                <button x-on:click="archive([])" type="button" class="btn bg-danger">Delete Data</button>
                                <button x-on:click="archive([],'Restore')" type="button" class="btn bg-warning">Restore
                                    Data</button>
                            @endcan
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <div class="">
                            <label for="filters_by_roles" class="block text-gray-600 mb-2">Filter by Roles</label>
                            <select id="filters_by_roles" class="form-select" wire:model.live="pagination.filters_by_roles">
                                <option value="">All</option>
                                @foreach ($roles as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-our-table-filter-deleted />
                        <x-our-table-input-search />
                    </div>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th class="w-10"><input type="checkbox" wire:model.live="pagination.selectAll"
                                    class="form-checkbox bg-primary"></x-our-table-th>
                            <x-our-table-th>Name</x-our-table-th>
                            <x-our-table-th>Username</x-our-table-th>
                            <x-our-table-th>Email</x-our-table-th>
                            <x-our-table-th>Role</x-our-table-th>
                            <x-our-table-th>Edit</x-our-table-th>
                            <x-our-table-th>Delete</x-our-table-th>
                        </tr>
                    </x-slot>
                    @foreach ($users as $item)
                        <tr>
                            <x-our-table-td><input type="checkbox" wire:model.live="pagination.selecteds"
                                    class="form-checkbox bg-primary" value="{{ $item->id }}"></x-our-table-td>
                            <x-our-table-td>{{ $item->name }}</x-our-table-td>
                            <x-our-table-td>{{ $item->username }}</x-our-table-td>
                            <x-our-table-td>{{ $item->email }}</x-our-table-td>
                            <x-our-table-td> {{ $item->roles?->first()?->name }}</x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                @can('update user management')
                                    @if ($item->deleted_at == null && $item->id != 1)
                                        <button wire:click="edit({{ $item->id }})"><i
                                                class="mdi mdi-pencil"></i></button>
                                    @endif
                                @endcan
                            </x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                @can('delete user management')
                                    @if ($item->deleted_at == null && $item->id != 3)
                                        <button x-on:click="archive({{ $item->id }})"><i
                                                class="mdi mdi-delete"></i></button>
                                    @elseif ($item->deleted_at !== null)
                                        <button x-on:click="archive({{ $item->id }},'Restore')"><i
                                                class="mdi mdi-backup-restore"></i></button>
                                    @endif
                                @endcan
                            </x-our-table-td>
                        </tr>
                    @endforeach
                </x-our-table>
            </div>
            {{ $users->links() }}

        </div>
    </div>
    <x-offcanvas title="{{ $formTitle }}">
        <livewire:admin.user-management.form />
    </x-offcanvas>

    @script
        <script>
            Alpine.data("initTable", () => ({
                archive(id, type = "Delete") {
                    Swal.fire({
                        title: `${type} User`,
                        text: "Are you sure?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false,
                        preConfirm: async () => {
                            await $wire.delete(id, type);
                        }
                    })
                },
                init() {
                    $wire.on("swal:error", ({
                        message
                    }) => {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: message,
                        })
                    })
                    $wire.on("swal:success", ({
                        message
                    }) => {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: message,
                        })
                    })
                }
            }))
        </script>
    @endscript
</div>
