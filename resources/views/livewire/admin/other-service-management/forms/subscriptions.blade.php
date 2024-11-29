<form autocomplete="off" wire:submit.prevent="submit" class="card p-5" x-data="form">
    <article class="grid md:grid-cols-2 gap-2">
        <div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2" for="service">Category</label>
                <input type="text" class="form-input w-full" id="service" value={{ $service['category'] }} disabled>
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2" for="service">Service</label>
                <input type="text" class="form-input w-full" id="service"
                    value="[{{ $service['service'] }}]{{ $service['name'] }}" disabled>
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2 capitalize" for="username">username</label>
                <input type="text" class="form-input w-full" id="username" wire:model="form.username">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2 capitalize" for="post">post</label>
                <input type="text" class="form-input w-full" id="post" wire:model="form.post">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2 capitalize" for="old_post">old post</label>
                <input type="text" class="form-input w-full" id="old_post" wire:model="form.old_post">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2 capitalize" for="min">min</label>
                <input type="text" class="form-input w-full" id="min" wire:model="form.min">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2 capitalize" for="max">max</label>
                <input type="text" class="form-input w-full" id="max" wire:model="form.max">
            </div>

            <a href="{{ route('admin.services.others.index', ['code' => request('code')]) }}"
                class="btn bg-danger text-white">
                Back
            </a>
            <button type="submit" x-on:click="save" class="btn bg-primary">
                Process
            </button>
        </div>
        <div class="text-xs">
            Refill : {{ $service['refill'] ? 'YES' : 'NO' }} <br>
            Min. Order : {{ $service['min'] }} <br>
            Max. Order : {{ $service['max'] }} <br>
            Rate : {{ $service['rate'] }} <br>
            @include('livewire.admin.other-service-management.details.Subscriptions')
        </div>
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
