<section>
    <div class="grid md:grid-cols-3 mb-5 gap-2">
        <x-widget-statistic color="info" title="Saldo" total="{{ $balance->balance }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
    </div>
    <form autocomplete="off" wire:submit.prevent="submit" class="card p-5" x-data="form">
        <article class="grid md:grid-cols-2 gap-2">
            <div>
                <div class="mb-2">
                    <label class="block text-gray-600 mb-2" for="service">Category</label>
                    <input type="text" class="form-input w-full" id="service" value={{ $service['category'] }}
                        disabled>
                </div>
                <div class="mb-2">
                    <label class="block text-gray-600 mb-2" for="service">Service</label>
                    <input type="text" class="form-input w-full" id="service"
                        value="[{{ $service['service'] }}]{{ $service['name'] }}" disabled>
                </div>
                {!! $service['type']->formBlade() !!}
                <a href="{{ url()->previous() }}" class="btn bg-danger text-white">
                    Back
                </a>
                <button type="submit" x-on:click="save" class="btn bg-primary">
                    Process
                </button>
            </div>
            <div>
                {!! $service['type']->details() !!}
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
</section>
