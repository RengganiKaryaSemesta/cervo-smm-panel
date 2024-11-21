@props([
    'title' => 'Stok Gudang A',
    'increase_from_last_month_in_percent' => '56',
    'total' => 623.635,
    'progressbar' => 35,
    'color' => 'danger',
])
<div class="card">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h4 class="card-title">{{ $title }}</h4>
            {{-- <div>
                <button data-fc-target="dropdown-{{str()->slug($title)}}" data-fc-type="dropdown" type="button"
                    data-fc-placement="bottom-end">
                    <i class="mdi mdi-dots-vertical text-xl"></i>
                </button>

                <div id="dropdown-{{str()->slug($title)}}"
                    class="hidden bg-white shadow rounded border dark:border-slate-700 fc-dropdown-open:translate-y-0 translate-y-3 origin-center transition-all duration-300 py-2 dark:bg-gray-800">
                    <a class="flex items-center py-1.5 px-5 text-sm transition-all duration-300 bg-transparent text-gray-800 dark:text-white hover:bg-stone-100 dark:hover:bg-slate-700 dark:hover:text-gray-200"
                        href="javascript:void(0)">
                        Lihat Detail
                    </a>
                </div>
            </div> --}}
        </div>

        <div class="flex items-center justify-between">
            <div class="bg-{{ $color }} text-white rounded-full text-xs px-2 py-0.5">
                {{ $increase_from_last_month_in_percent }}% <i class="mdi mdi-trending-up"></i>
            </div>

            <div class="text-end">
                <h2 class="text-3xl font-normal text-gray-800 dark:text-white mb-1"> {{ $total }} </h2>
                <p class="text-gray-400 font-normal">Berdasarkan Periode</p>
            </div>

        </div>

        <div class="flex w-full h-[5px] bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 mt-6">
            <div class="flex flex-col justify-center overflow-hidden bg-{{ $color }}" role="progressbar"
                style="width: {{ $progressbar }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>
