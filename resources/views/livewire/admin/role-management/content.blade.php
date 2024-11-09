<div>
    <div class="card">
        <div class="p-6" x-data="initTable">
            <div class="align-middle">
                <div
                    class="flex {{ auth()->user()->can('create role management') ? 'justify-between' : 'justify-end' }} flex-col gap-2 md:flex-row items-center">
                    @can('create role management')
                        <button wire:click="add" type="button" class="btn bg-primary ">Data Baru</button>
                    @endcan
                    <x-our-table-input-search/>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th>Nama</x-our-table-th>
                            <x-our-table-th>Deskripsi</x-our-table-th>
                            <x-our-table-th class="w-10">Edit</x-our-table-th>
                            <x-our-table-th class="w-10">Hapus</x-our-table-th>
                        </tr>
                    </x-slot>
                    @foreach ($roles as $item)
                        <tr>
                            <x-our-table-td>
                                {{ $item->name }}
                            </x-our-table-td>
                            <x-our-table-td>
                                {{ $item->description }}
                            </x-our-table-td>
                            <x-our-table-td class="text-center">
                                @if ($item->id !== 1)
                                    @can('update role management')
                                        <button wire:click="edit({{ $item->id }})"><i
                                                class="mdi mdi-pencil text-primary"></i></button>
                                    @endcan
                                @endif
                            </x-our-table-td>
                            <x-our-table-td class="text-center">
                                @if ($item->id !== 1)
                                    @can('delete role management')
                                        <button x-on:click="deleteItem({{ $item->id }})"><i
                                                class="mdi mdi-delete text-primary"></i></button>
                                    @endcan
                                @endif
                            </x-our-table-td>
                        </tr>
                    @endforeach
                    <x-slot name="pagination">
                        {{ $roles->links() }}
                    </x-slot>
                </x-our-table>
            </div>


        </div>
    </div>
    <x-offcanvas title="{{ $formTitle }}">
        <livewire:admin.role-management.form />
    </x-offcanvas>
    @push('styles')
        <link href="{{ asset('vendor') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    @endpush
    <script src="{{ asset('vendor') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('vendor') }}/assets/js/pages/extended-sweetalert.init.js"></script>
    @script
        <script>
            Alpine.data('initTable', () => ({
                deleteItem(id) {
                    Swal.fire({
                        title: 'Delete Role',
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
