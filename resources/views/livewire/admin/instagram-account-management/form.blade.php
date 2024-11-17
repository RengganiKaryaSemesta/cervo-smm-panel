<form autocomplete="off" wire:submit.prevent="submit">
    <article x-data="form">
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="username">Username</label>
            <input type="text" class="form-input w-full" id="username" wire:model="form.username">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="email">Email</label>
            <input type="email" class="form-input w-full" id="email" wire:model="form.email">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="password">Password</label>
            <input type="text" class="form-input w-full" id="password" wire:model="form.password">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="cookie">Cookie</label>
            <textarea class="form-input w-full" id="cookie" wire:model="form.cookie"></textarea>
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
                        await $wire.submit();
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