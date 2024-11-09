<div class="relative mt-2">
    @if ($disabled)
        <div class="bg-gray-500/20 z-20 absolute left-0 right-0 top-0 bottom-0"></div>
    @endif
    <div x-data="{ open: false }">
        <button @click="open = !open" type="button" class="form-input text-start">
            <span class="block truncate">
                @if ($value)
                    {!! $this->getValueLabel() !!}
                @else
                    Pilih satu
                @endif
            </span>
            @if ($value)
                <span x-cloak x-on:click="$wire.set('search',null)"
                    class="absolute right-7 inset-y-0 flex items-center cursor-pointer">
                    <i class="mdi mdi-close text-red-300"></i>
                </span>
            @endif
            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="h-5 w-5 text-gray-800" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                        clip-rule="evenodd" />
                </svg>
            </span>
        </button>

        <div x-show="open" @click.away="open = false;$wire.set('search',null)" x-cloak
            class="absolute z-50 mt-1 w-full overflow-hidden rounded-md bg-white py-1 text-base shadow-lg">
            @if ($searchFunction)
                <div class="px-2 mb-2">
                    <input type="search" wire:model.live.debouce.1000ms="search" class="form-input"
                        placeholder="Cari...">
                </div>
            @endif
            <ul class="max-h-60 overflow-auto text-sm pb-2">
                @forelse ($options as $item)
                    <li x-on:click="$wire.setValue('{{ $item['id'] }}','{{ $item['name'] }}');open=false;"
                        class="cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-primary/80 hover:text-[#00c677]"
                        :class="{ 'bg-primary text-[#00c677]': '{{ $value && $value === $item['id'] }}' }">
                        <span class="font-normal block truncate">{!! $item['name'] !!}</span>
                    </li>
                @empty
                    <li class="text-center">{{ __('No Data') }}</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
