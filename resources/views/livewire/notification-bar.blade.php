<div class="relative md:flex hidden">
    <button data-fc-type="dropdown" wire:ignore data-fc-placement="bottom-end" type="button" class="nav-link p-2">
        @persist('notif')
            <span class="sr-only">View notifications</span>
        @endpersist
        <span class="flex items-center justify-center h-6 w-6">
            @persist('notif')
                <i data-lucide="bell"></i>
            @endpersist
            <span x-ref="total_notification"
            wire:poll.15s="handleRefreshData"
                class="absolute top-3 end-1.5 w-4 h-4 flex items-center justify-center rounded-full bg-danger text-white  font-medium text-[10px]">{{ $unread_data->count() }}</span>
        </span>
    </button>
    <div
        class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-80 z-50 transition-[margin,opacity] duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg">

        <div class="p-4">
            <div class="flex items-center justify-between">
                <h6 class="text-sm"> Notification</h6>
                <a wire:click="clearAll" x-on:click="$refs.total_notification.innerHTML = 0" href="javascript: void(0);"
                    class="text-gray-500">
                    <small>Clear All</small>
                </a>
            </div>
        </div>

        <div class="p-4 h-80" data-simplebar>
            @foreach ($data as $day => $items)
                <h5 class="text-xs text-gray-500 dark:text-gray-300 mb-2">{{ $day }}</h5>
                @foreach ($items as $item)
                    {{-- <a href="javascript:void(0);" class="block mb-4"> --}}
                        <div class="card-body mb-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex justify-center items-center h-9 w-9 rounded-full bg text-white bg-primary">
                                        <i class="mdi mdi-information-outline text-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow  ms-2">
                                    <h5 class="text-sm truncate font-semibold mb-1">{{ $item->data['title'] }}<small
                                            class="font-normal text-gray-500 ms-1">{{ $item->created_at->diffForHumans() }}</small>
                                    </h5>
                                    <small class="noti-item-subtitle text-muted">{!! $item->data['detail'] !!}</small>
                                </div>
                            </div>
                        </div>
                    {{-- </a> --}}
                @endforeach
            @endforeach
        </div>


    </div>
    @script
        <script>
            $wire.on('notify:refresh-data', ({
                total
            }) => {
                $refs.total_notification.innerHTML = total
            })
        </script>
    @endscript
</div>
