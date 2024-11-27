<div>
    <div class="card">
        <div class="p-6">
            <div class="align-middle mb-2" x-data="initTable">
                <div class="flex justify-between flex-col gap-2 md:flex-row items-center">
                    <div>
                        @can('create smm provider management')
                            <button wire:click="add" type="button" class="btn bg-primary ">Create Account</button>
                        @endcan
                    </div>
                    <x-our-table-input-search />
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th>Name</x-our-table-th>
                            <x-our-table-th>API Url</x-our-table-th>
                            <x-our-table-th>API Key</x-our-table-th>
                            <x-our-table-th>Edit</x-our-table-th>
                            <x-our-table-th>Delete</x-our-table-th>
                        </tr>
                    </x-slot>
                    @forelse ($data as $item)
                        <tr>
                            <x-our-table-td>{{ $item->name }}</x-our-table-td>
                            <x-our-table-td>{{ $item->api_url }}</x-our-table-td>
                            <x-our-table-td>{{ $item->api_key }}</x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                @can('update smm provider management')
                                    @if ($item->deleted_at == null)
                                        <button wire:click="edit({{ $item->id }})"><i
                                                class="mdi mdi-pencil"></i></button>
                                    @endif
                                @endcan
                            </x-our-table-td>
                            <x-our-table-td class="text-center text-primary w-10">
                                @can('delete smm provider management')
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
                            <x-our-table-td colspan="4" class=" text-center">
                                <p class="text-center w-full">Data not found!</p>
                            </x-our-table-td>
                        </tr>
                    @endforelse
                </x-our-table>
            </div>
            {{ $data->links() }}
        </div>
    </div>
    <x-offcanvas title="{{ $formTitle }}">
        <livewire:admin.smm-provider-management.form />
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
