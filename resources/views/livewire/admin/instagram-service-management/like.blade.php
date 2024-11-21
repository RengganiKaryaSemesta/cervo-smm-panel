<section class="card p-5">
    {{-- https://www.instagram.com/p/CwZyRTzvHj1/?img_index=1 --}}
    <form autocomplete="off" wire:submit.prevent="submit" class="grid grid-cols-2">
        <article x-data="form" >
            <div class="mb-4">
                <label class="block text-gray-600 mb-2 uppercase" for="url">URL</label>
                <input type="text" class="form-input w-full" id="url" wire:model="form.url">
            </div>
            <div class="mb-4">
            <label class="block text-gray-600 mb-2 uppercase" for="account_count">Number of Account</label>
                <input type="text" x-mask="999999" class="form-input w-full" id="account_count" wire:model="form.account_count">
            </div>
            <button type="submit" x-on:click="save" class="btn bg-primary">
                Process Now
            </button>
        </article>
    
        @script
        <script>
            Alpine.data('form', () => ({
                save(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Save & Process',
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
</section>