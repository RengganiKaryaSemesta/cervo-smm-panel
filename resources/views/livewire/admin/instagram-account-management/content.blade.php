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
                        <x-our-table-th>Actions</x-our-table-th>
                    </tr>
                </x-slot>

                <tbody>
                    @if ($accounts->isNotEmpty())
                        @foreach ($accounts as $account)
                            <tr>
                                <x-our-table-td>{{ $account->username }}</x-our-table-td>
                                <x-our-table-td>{{ $account->email }}</x-our-table-td>
                                <x-our-table-td>{{ $account->password }}</x-our-table-td>
                                <x-our-table-td>{{ $account->status ? 'Active' : 'Inactive' }}</x-our-table-td>
                                <x-our-table-td>
                                    <button wire:click="edit({{ $account->id }})">Edit</button>
                                    <button wire:click="delete({{ $account->id }})">Delete</button>
                                </x-our-table-td>
                            </tr>
                        @endforeach
                    @else
                        <tr class=" text-center">
                            <td class="col-span-5 py-4">
                                <p class="text-center w-full">Account Instagram not found!</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
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
