<form autocomplete="off" wire:submit.prevent="submit">
    <article x-data='form'>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="name">Name</label>
            <input type="text" class="form-input" id="name" wire:model="form.name">
        </div>
        <div class="mb-2">
            <label class="block text-gray-600 mb-2" for="description">Description</label>
            <input type="text" class="form-input" id="description" wire:model="form.description">
        </div>
        <div class="grid grid-cols-2 mb-2">
            @foreach ($permissions as $item)
                <div class="flex items-center mb-2">
                    <input wire:model="form.permissions" value="{{$item->name}}" class="form-switch text-primary" type="checkbox" id="per-{{$item->id}}">
                    <div class="ms-1.5">
                        <label  for="per-{{$item->id}}">{{ $item->name }}</label>
                        <small>{{ $item->description }}</small>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" x-on:click="save" class="btn bg-primary ">
            Save Role
        </button>
    </article>
    @script
        <script>
            Alpine.data('form', () => ({
                save(e) {
                    e.preventDefault();
                    // save
                    Swal.fire({
                        title: 'Save Role',
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
