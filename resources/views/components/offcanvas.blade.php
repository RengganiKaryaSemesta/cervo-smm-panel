@props([
    'title' => 'Title',
])
<div x-data>
    <button class="hidden" data-fc-type="offcanvas" x-ref="offcanvascontroller" @offcanvascontroller.window="$refs.offcanvascontroller.click()"></button>
    <div wire:ignore.self
        class="fc-offcanvas-open:translate-x-0 translate-x-full fixed top-0 end-0 transition-all duration-300 rtl:-translate-x-full transform h-full max-w-xs md:max-w-2xl w-full  z-50 bg-white border-l dark:bg-gray-800 dark:border-gray-700 hidden"
        {{ $attributes }}>
        <div class="flex justify-between items-center py-2 px-4 border-b dark:border-gray-700">
            <h3 class="font-medium" x-ref=>
                {{ $title }}
            </h3>
            <button
                class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-700  text-sm dark:text-gray-500 dark:hover:text-gray-400"
                data-fc-dismiss type="button" x-ref="offcanvascontrollerDismiss" @offcanvascontrollerdismiss.window="$refs.offcanvascontrollerDismiss.click()">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <div class="p-4 h-[90%] overflow-auto relative">
            {{ $slot }}
        </div>
    </div>   
</div>
