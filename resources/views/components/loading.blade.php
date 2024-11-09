<div wire:loading @if (isset($target)) wire:target="{{ $target }}" @endif
    @if (isset($except)) wire:target.except="{{ $except }}" @endif
    class="h-full w-full fixed bottom-0 bg-red-800/80 left-0 top-0 z-50 text-center my-auto">
    <div class="div"></div>
    <div class="flex justify-center h-full items-center">
        <span class="text-white">Loading...</span>
        <div class="animate-spin inline-block w-8 h-8 border-[3px] border-current border-t-transparent text-warning rounded-full"
            role="status" aria-label="loading">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
