<th
    class="{{ $attributes->merge(['class' => 'border border-[#0b194e] font-semibold p-2 text-primary text-start'])['class'] }}">
    @if ($attributes->has('orderColumnName'))
        <div class="relative flex justify-between">
            {{ $slot }}
            @if (isset($pagination['order'][0]))
                @if ($pagination['order'][1] == 'DESC' && $pagination['order'][0] == $attributes['orderColumnName'])
                    <button type="button"
                        wire:click="set('pagination.order',['{{ $attributes['orderColumnName'] }}','ASC'])"> <i
                            class="mdi-sort-descending mdi"></i> </button>
                @else
                    <button type="button"
                        wire:click="set('pagination.order',['{{ $attributes['orderColumnName'] }}','DESC'])"> <i
                            class="mdi-sort-ascending mdi"></i> </button>
                @endif
            @else
                <button type="button" wire:click="set('pagination.order',['{{ $attributes['orderColumnName'] }}','DESC'])">
                    <i class="mdi-sort-descending mdi"></i> </button>
            @endif
        </div>
    @else
        {{ $slot }}
    @endif
</th>
