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
                <input type="text" x-mask="99999" min="0" class="form-input w-full" id="quantity"
                    wire:model.live="form.quantity">
            </div>
            <div class="mb-2">
                <p>Total: {{ $this->calculate() }}</p>
            </div>
            @include('livewire.admin.other-service-management.segments.button-form')
        </div>
        <div class="text-xs">
            Refill : {{ $service['refill'] ? 'YES' : 'NO' }} <br>
            Min. Order : {{ $service['min'] }} <br>
            Max. Order : {{ $service['max'] }} <br>
            Rate : {{ $service['rate'] }} <br>
            @if ($service['note'] == '')
                @include('livewire.admin.other-service-management.details.Subscriptions')
            @else
                {!! $service['note'] !!}
            @endif

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
