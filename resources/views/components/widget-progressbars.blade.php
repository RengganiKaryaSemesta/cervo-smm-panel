@props([
    'title' => 'Stock per Gudang',
    'increase_from_last_month_in_percent' => '56',
    'items' => [],
])
<div class="card">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h4 class="card-title">{{ $title }}</h4>

            <div>
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
            </div>
        </div>

        <div class="flex flex-col gap-5">
            @foreach ($items as $item)
                <div>
                    <h5 class="flex items-center justify-between text-gray-800">{{ $item['title'] }} <span
                            class="text-{{ $item['color'] }} float-end">{{ $item['progressbar'] }}%</span></h5>
                    <div class="flex w-full h-[5px] bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 mt-2">
                        <div class="flex flex-col justify-center overflow-hidden bg-{{ $item['color'] }}"
                            role="progressbar" style="width: {{ $item['progressbar'] }}%" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
