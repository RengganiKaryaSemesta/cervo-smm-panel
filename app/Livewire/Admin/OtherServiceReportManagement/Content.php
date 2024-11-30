<?php

namespace App\Livewire\Admin\OtherServiceReportManagement;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\SmmProvider;
use Livewire\WithPagination;
use App\Models\SmmProviderOrder;
use Livewire\Attributes\Computed;
use App\Traits\PaginationVariable;
use App\Jobs\ApiSmmProviderStatusProcess;
use App\Services\SmmProvider\ApiSmmProvider;

class Content extends Component
{
    use WithPagination, PaginationVariable;
    public function mount()
    {
        $this->pagination['startDate'] = isset($this->pagination['startDate'])
            ? Carbon::parse($this->pagination['startDate'])->format('Y-m-d')
            : now()->startOfMonth()->startOfDay()->format('Y-m-d');
        $this->pagination['endDate']   = isset($this->pagination['endDate'])
            ? Carbon::parse($this->pagination['endDate'])->format('Y-m-d')
            : now()->endOfMonth()->endOfDay()->format('Y-m-d');
    }
    #[Computed(cache: TRUE)]
    public function getData()
    {
        ApiSmmProviderStatusProcess::dispatch();
        return SmmProviderOrder::with(
            [
                'smmProvider',
                'creator',
            ]
        )
        ->search($this->pagination['search'])
        ->where(
                function ($query) {
                    return $query->where(
                        'status',
                        '!=',
                        'Active'
                    )
                        ->orWhereNot(
                            'start_count',
                            '0'
                        )->orWhereNot(
                            'remains',
                            '0'
                        );
                }
            )
            ->when(
                isset($this->pagination['filters_status']) && $this->pagination['filters_status'],
                function ($query) {
                    return $query->where(
                        'status',
                        $this->pagination['filters_status']);
                })
                ->filterRange($this->pagination)
            ->customSingleOrders($this->pagination)
            ->paginate($this->pagination['limit']);
    }
    #[Computed(persist: TRUE, seconds: 10000, cache: TRUE, tags: 'get-report-balances')]
    public function getBalances()
    {
        $smmProviders = SmmProvider::whereNotNull('api_url')->whereNotNull('api_key')->get();
        return $smmProviders->map(
            function ($smmProvider) {
                $result               = cache()->remember(
                    'smm-provider-balance-' . $smmProvider->id,
                    60,
                    function () use ($smmProvider) {
                        return (new ApiSmmProvider(
                            $smmProvider->api_url,
                            $smmProvider->api_key
                        ))->balance();
                    }
                );
                $smmProvider->balance = $result->balance;
                return $smmProvider;
            }
        );
    }
    public function render()
    {
        return view(
            'livewire.admin.other-service-report-management.content',
            [
                'data'     => $this->getData(),
                'balances' => $this->getBalances(),
            ]
        )->title('Report - Other Services')->layout('layouts.admin.app');
    }
}
