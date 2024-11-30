<?php

namespace App\Livewire\Admin\OtherServiceManagement;

use App\Jobs\ApiSmmProviderServiceProcess;
use App\Services\SmmProvider\ApiSmmProvider;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\SmmProvider;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use App\Traits\PaginationVariable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class Content extends Component
{
    use WithPagination, PaginationVariable;
    public             $formTitle, $service_category = NULL;
    public SmmProvider $smmProvider;
    public             $providers;
    public function mount($code = NULL)
    {
        $this->providers = SmmProvider::get();
        if ($this->providers->isEmpty())
            abort(404);
        if ($code) {
            $this->smmProvider = SmmProvider::where(
                'code',
                $code
            )->firstOrFail();
            return;
        }
        $this->smmProvider = $this->providers->first();
    }
    #[On('offcanvascontrollerdismiss'), Computed(cache: TRUE)]
    public function getData()
    {
        $cacheKey = 'api_smm_provider_service_process_' . $this->smmProvider->code;
        if (Cache::has($cacheKey)) {
            $result = Cache::get($cacheKey);
        }
        else {
            ApiSmmProviderServiceProcess::dispatch($this->smmProvider);
            $result = collect([]);
        }
        $result = $result->when(
            $this->service_category != NULL,
            function ($data) {
                return $data->where(
                    'category',
                    $this->service_category
                );
            }
        );
        if (isset($this->pagination["order"][0])) {
            $result = strtolower($this->pagination["order"][1]) == 'desc'
                ? $result->sortByDesc($this->pagination['order'][0])
                : $result->sortBy($this->pagination['order'][0]);
        }
        else {
            $result = $result->sortBy('service');
        }
        // search dengan this->pagination['search']
        if ($this->pagination["search"] != "") {
            $result = $result->filter(
                function ($item) {
                    return \Str::contains(
                        strtolower($item->name),
                        strtolower($this->pagination["search"]))
                        || \Str::contains(
                            strtolower($item->service),
                            strtolower($this->pagination["search"]));
                });
        }
        $page          = $this->getPage();
        $perPage       = $this->pagination['limit'];
        $totalItems    = $result->count();
        $paginatedData = $result->forPage(
            $page,
            $perPage
        );

        return new LengthAwarePaginator(
            $paginatedData,
            $totalItems,
            $perPage,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
    #[Computed(persist: TRUE, cache: TRUE)]
    public function getCategories()
    {
        $cacheKey = 'api_smm_provider_service_process_' . $this->smmProvider->code;
        if (Cache::has($cacheKey)) {
            $result = Cache::get($cacheKey);
        }
        else {
            ApiSmmProviderServiceProcess::dispatch($this->smmProvider);
            $result = collect([]);
        }
        $categories = $result->pluck('category')->unique();
        return $categories;
    }
    public function render()
    {
        return view(
            'livewire.admin.other-service-management.content',
            [
                'data'       => $this->getData(),
                'categories' => $this->getCategories(),
            ]
        )->title('Other Services')->layout('layouts.admin.app');
    }
}
