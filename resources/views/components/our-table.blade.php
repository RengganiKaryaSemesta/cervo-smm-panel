@props(['paginationPosition' => 'bottom'])
<section>
    @if (isset($pagination))
        @if ($paginationPosition == 'top')
            <div id="paginator-area" class="mt-2">
                {{ $pagination }}
            </div>
        @endif
    @endif
    <div class="relative overflow-auto mt-2">
        <table class="border-collapse min-w-full border border-[#0b194e] bg-white text-xs shadow-sm">
            <thead class="bg-[#0b194e]/30">
                <tr>
                    {{ $header }}
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>

    </div>
    @if (isset($pagination))
        @if ($paginationPosition == 'bottom')
            <div id="paginator-area" class="mt-2">
                {{ $pagination }}
            </div>
        @endif
    @endif
</section>
