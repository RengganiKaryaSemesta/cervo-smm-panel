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
    public             $formTitle,  $service_category = null;
    public SmmProvider $smmProvider;
    public             $providers;
    public function mount($code = null)
    {
        $this->providers = SmmProvider::get();
        if ($code) {
            $this->smmProvider = SmmProvider::where(
                'code',
                $code
            )->firstOrFail();
            return;
        }
        $this->smmProvider = $this->providers->first();
    }
    public function add()
    {
        $this->formTitle = 'Create a new Data';
        $this->dispatch(
            'form-event',
            data: null
        );
        $this->dispatch(
            'offcanvascontroller',
            data: null
        );
    }
    public function edit($id)
    {
        try {
            $data            = SmmProvider::findOrFail($id);
            $this->formTitle = 'Edit Data';
            $this->dispatch(
                'form-event',
                data: $data
            );
            $this->dispatch('offcanvascontroller');
        }
        catch (\Throwable $th) {
            $this->dispatch(
                'swal:error',
                message: $th->getMessage()
            )->self();
        }

    }
    #[On('offcanvascontrollerdismiss'), Computed(cache: true)]
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
        $result        = $result->when(
            $this->service_category != null,
            function ($data) {
                return $data->where(
                    'category',
                    $this->service_category
                );
            }
        );
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
    #[Computed(persist: true, cache: true)]
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
        $categories     = $result->pluck('category')->unique();
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
