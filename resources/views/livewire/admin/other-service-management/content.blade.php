<div>
    <x-loading />
    <div class="card">
        <div class="p-6">
            <div class="md:flex mb-2 items-stretch ">
                @foreach ($providers as $item)
                    <a wire:navigate href="{{ route('admin.services.others.index', ['code' => $item->code]) }}"
                        class="border-y border-r hidden md:block border-l p-5 last-of-type:border-l-0 {{ $item->code == $smmProvider->code ? 'font-bold text-neutral-800 border-b-primary' : 'text-neutral-700' }}">{{ $item->name }}</a>
                @endforeach
                <select class="md:hidden form-select" name="" id=""
                    onchange="window.location.href=this.value">
                    @foreach ($providers as $item)
                        <option value="{{ route('admin.services.others.index', ['code' => $item->code]) }}"
                            {{ $item->code == $smmProvider->code ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="align-middle mb-2" x-data="initTable">
                <div class="flex justify-between flex-col gap-2 md:flex-row items-end">
                    <div class="w-full">
                        <div>
                            <label class="block text-gray-600 mb-2" for="service_category">{{ __('Category') }}</label>
                            <div wire:ignore>
                                <select id="service_category" class="w-full" wire:model="service_category">
                                    <option value="" selected disabled>Pilih satu</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <x-our-table>
                    <x-slot name="header">
                        <tr>
                            <x-our-table-th>ID</x-our-table-th>
                            <x-our-table-th>Name</x-our-table-th>
                            <x-our-table-th>Rate/1000</x-our-table-th>
                            <x-our-table-th>Min/Max</x-our-table-th>
                            <x-our-table-th>Average time</x-our-table-th>
                            @can('read smm provider order management')
                                <x-our-table-th>Order</x-our-table-th>
                            @endcan
                        </tr>
                    </x-slot>
                    @forelse ($data as $item)
                        <tr>
                            <x-our-table-td>{{ $item->service }}</x-our-table-td>
                            <x-our-table-td>{{ $item->name }}</x-our-table-td>
                            <x-our-table-td>{{ $smmProvider->service_currency_code . $item->rate }}</x-our-table-td>
                            <x-our-table-td>{{ $item->min }}/{{ $item->max }}</x-our-table-td>
                            <x-our-table-td>Not enough data </x-our-table-td>
                            @can('read smm provider order management')
                                <x-our-table-td> <a
                                        href="{{ route('admin.services.others.form', ['code' => $smmProvider->code, 'serviceId' => $item->service]) }}"
                                        class="btn bg-primary">Order</a> </x-our-table-td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <x-our-table-td colspan="6" class=" text-center">
                                <div @if ($data->total() == 0) wire:poll.visible @endif
                                    class="text-center w-full">Data not found, please wait a moment as the data is
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
                    const warehouse = $('#service_category').selectize({
                        delimiter: ',',
                        maxItems: 1,
                        onChange: async function(value) {
                            $wire.set('service_category', value)
                        },
                    })
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
