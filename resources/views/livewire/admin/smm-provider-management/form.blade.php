<form autocomplete="off" wire:submit.prevent="submit">
    <article x-data="form">
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="name">name</label>
            <input type="text" class="form-input w-full" id="name" wire:model="form.name">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="service_currency_code">Currency Code</label>
            <input type="text" class="form-input w-full" id="service_currency_code"
                wire:model="form.service_currency_code" placeholder="Rp">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="api_service">API Service</label>
            <select id="api_service" class="form-select" wire:model="form.api_service">
                <option value="ApiSmmProvider">ApiSmmProvider</option>
                <option value="ApiSmmProvider2">ApiSmmProvider2</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="api_url">API Url</label>
            <input type="text" class="form-input w-full" id="api_url" wire:model="form.api_url">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="api_key">API Key</label>
            <input type="text" class="form-input w-full" id="api_key" wire:model="form.api_key">
        </div>
        <div class="mb-4">
            <label class="block text-gray-600 mb-2" for="secret_key">Secret Key</label>
            <input type="text" class="form-input w-full" id="secret_key" wire:model="form.secret_key">
        </div>
        <button type="submit" x-on:click="save" class="btn bg-primary">
            Save Data
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
                    $wire.on('swal:error', ({
                        message
                    }) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: message,
                        });
                    });
                    $wire.on('swal:success', ({
                        message
                    }) => {
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
