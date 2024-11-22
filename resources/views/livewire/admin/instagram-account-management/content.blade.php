<div>
    <div class="card">
        <div class="p-6" x-data="initTable">
            <button type="button" class="btn bg-primary mb-5" wire:click="add">Add New Instagram Account</button>

            <x-our-table class="mb-10">
                <x-slot name="header">
                    <tr>
                        <x-our-table-th>Username</x-our-table-th>
                        <x-our-table-th>Email</x-our-table-th>
                        <x-our-table-th>Password</x-our-table-th>
                        <x-our-table-th>Status</x-our-table-th>
                        <x-our-table-th>Edit</x-our-table-th>
                        <x-our-table-th>Delete</x-our-table-th>
                    </tr>
                </x-slot>
                @forelse ($accounts as $items)
                    <tr>
                        <x-our-table-td>{{ $items->username }}</x-our-table-td>
                        <x-our-table-td>{{ $items->email }}</x-our-table-td>
                        <x-our-table-td>{{ $items->password }}</x-our-table-td>
                        <x-our-table-td>{{ $items->status ? 'Active' : 'Inactive' }}</x-our-table-td>
                        <x-our-table-td class="text-center text-primary w-10">
                            @can('instagramAccount.update')
                                @if ($item->deleted_at == null)
                                    <button wire:click="edit({{ $item->id }})"><i class="mdi mdi-pencil"></i></button>
                                @endif
                            @endcan
                        </x-our-table-td>
                        <x-our-table-td class="text-center text-primary w-10">
                            @can('instagramAccount.delete')
                                @if ($item->deleted_at == null)
                                    <button x-on:click="archive({{ $item->id }})"><i
                                            class="mdi mdi-delete"></i></button>
                                @elseif ($item->deleted_at !== null)
                                    <button x-on:click="archive({{ $item->id }},'Restore')"><i
                                            class="mdi mdi-backup-restore"></i></button>
                                @endif
                            @endcan
                        </x-our-table-td>
                    </tr>
                @empty
                    <tr class=" text-center">
                        <x-our-table-td class="py-4" colspan="6">
                            <p class="text-center w-full">Account Instagram not found!</p>
                        </x-our-table-td>
                    </tr>
                @endforelse
            </x-our-table>
            <div class="my-5 w-full flex justify-endi items-center">
                {{ $accounts->links() }}
            </div>
        </div>
    </div>
    <x-offcanvas title="{{ $formTitle }}">
        <livewire:admin.instagram-account-management.form />
    </x-offcanvas>
</div>
