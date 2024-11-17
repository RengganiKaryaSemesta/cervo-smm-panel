<form autocomplete="off" wire:submit.prevent="save">
    <article x-data="form">
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="username">Username</label>
            <input type="text" class="form-input w-full" id="username" wire:model="username">
            @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="name">Name</label>
            <input type="text" class="form-input w-full" id="name" wire:model="name">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="email">Email</label>
            <input type="email" class="form-input w-full" id="email" wire:model="email">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="password">Password</label>
            <input type="password" class="form-input w-full" id="password" wire:model="password">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="cookie">Cookie</label>
            <textarea class="form-input w-full" id="cookie" wire:model="cookie"></textarea>
            @error('cookie') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-600 mb-2">Status</label>
            <div class="flex items-center">
                <label class="inline-flex items-center mr-4">
                    <input type="radio" value="1" class="form-radio" wire:model="status">
                    <span class="ml-2">Active</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" value="0" class="form-radio" wire:model="status">
                    <span class="ml-2">Inactive</span>
                </label>
            </div>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" x-on:click="save" class="btn bg-primary">
            Save Instagram Account
        </button>
    </article>

    @script
    <script>
        Alpine.data('form', () => ({
            save(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Save Instagram Account',
                    text: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: async () => {
                        await $wire.save();
                    }
                });
            },
            init() {
                $wire.on('swal:error', ({ message }) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message,
                    });
                });
                $wire.on('swal:success', ({ message }) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: message,
                    });
                });
            }
        }));
    </script>
    @endscript
</form>
