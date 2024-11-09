<form autocomplete="off" wire:submit.prevent="submit">
    <article x-data='form'>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="name">Name</label>
            <input type="text" class="form-input" id="name" wire:model="form.name">
        </div>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="username">Username</label>
            <input type="text" class="form-input" id="username" wire:model="form.username">
        </div>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="email">Email</label>
            <input type="email" class="form-input" id="email" wire:model="form.email">
        </div>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="role">{{ __('Role') }}</label>
            <livewire:components.forms.select-input :options="$roles" wire:model.live="form.role"
                searchFunction="getRoles" :key="'rolesUser'"/>
        </div>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="password">Password 
                @isset($form['id'])
                    <small>(Kosongkan jika tidak ingin mereset password)</small>
                @endisset
            </label>
            <input autocomplete="new-password" id="password" wire:model="form.password" type="password"
                class="form-input">
        </div>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="password_confirmation">Password Confirmation</label>
            <input autocomplete="new-password" id="password_confirmation" wire:model="form.password_confirmation"
                type="password" class="form-input">
        </div>
        <button type="submit" x-on:click="save" class="btn bg-primary ">
            Save
        </button>
    </article>
    @script
        <script>
            Alpine.data('form', () => ({
                save(e) {
                    e.preventDefault();
                    // save
                    Swal.fire({
                        title: 'Save Data',
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
</form>
