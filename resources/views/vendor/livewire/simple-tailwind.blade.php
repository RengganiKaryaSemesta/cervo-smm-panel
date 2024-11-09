@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-primary-300 bg-white border border-primary-300 cursor-default leading-5 rounded-md select-none">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" dusk="previousPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-primary-900 bg-white border border-primary-300 leading-5 rounded-md hover:text-primary-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-primary-100 active:text-primary-900 transition ease-in-out duration-150">
                                {!! __('pagination.previous') !!}
                        </button>
                    @else
                        <button
                            type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-primary-900 bg-white border border-primary-300 leading-5 rounded-md hover:text-primary-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-primary-100 active:text-primary-900 transition ease-in-out duration-150">
                                {!! __('pagination.previous') !!}
                        </button>
                    @endif
                @endif
            </span>
            <div class="flex items-center">
                        <p class="text-xs text-gray-700 dark:text-gray-300 leading-5">
                            <span>{!! __('Halaman') !!}</span>
                            <span class="font-medium">{{  $paginator->currentPage() }}</span>
                            <span>{!! __('dari') !!}</span>
                            <span class="font-medium">{{  $paginator->lastPage() }}</span>
                        </p>
            </div>
            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" dusk="nextPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-primary-900 bg-white border border-primary-300 leading-5 rounded-md hover:text-primary-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-primary-100 active:text-primary-900 transition ease-in-out duration-150">
                                {!! __('pagination.next') !!}
                        </button>
                    @else
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-primary-900 bg-white border border-primary-300 leading-5 rounded-md hover:text-primary-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-primary-100 active:text-primary-900 transition ease-in-out duration-150">
                                {!! __('pagination.next') !!}
                        </button>
                    @endif
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-primary-300 bg-white border border-primary-300 cursor-default leading-5 rounded-md select-none">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
