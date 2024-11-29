<form autocomplete="off" wire:submit.prevent="submit" class="card p-5" x-data="form">
    <article class="grid md:grid-cols-2 gap-2">
        <div>
            @include('livewire.admin.other-service-management.segments.category-and-service')
            <div class="mb-2">
                <label class="block text-gray-600 mb-2 capitalize" for="link">link</label>
                <input type="text" class="form-input w-full" id="link" wire:model="form.link">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 mb-2 capitalize" for="quantity">quantity</label>
                <input type="text" x-mask="999999" class="form-input w-full" id="quantity" wire:model.live="form.quantity">
            </div>
            <div class="mb-2">
                <label class="block text-gray-600 capitalize" for="username">username</label>
                <small class="text-xs mb-2">Username of the comment owner               </small>
                <input type="text" class="form-input w-full" id="username" wire:model="form.username">
            </div>
            <div class="mb-2">
                <p>Total: {{$this->calculate()}}</p>
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
