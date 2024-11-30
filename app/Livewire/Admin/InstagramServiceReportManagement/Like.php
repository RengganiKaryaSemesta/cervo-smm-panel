<?php

namespace App\Livewire\Admin\InstagramServiceReportManagement;

use App\Enums\InstagramServiceItemStatus;
use App\Enums\InstagramServiceStatus;
use App\Enums\InstagramServiceType;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\InstagramService;
use App\Traits\PaginationVariable;

class Like extends Component
{
    use WithPagination, PaginationVariable;
    #[Url]
    public $filters = [
        'search'    => null,
        'startDate' => null,
        'endDate'   => null,
    ];
    public function mount()
    {
        $this->filters['startDate'] = $this->filters['startDate']
            ? Carbon::parse($this->filters['startDate'])->format('Y-m-d')
            : now()->startOfMonth()->startOfDay()->format('Y-m-d');
        $this->filters['endDate']   = $this->filters['endDate']
            ? Carbon::parse($this->filters['endDate'])->format('Y-m-d')
            : now()->endOfMonth()->endOfDay()->format('Y-m-d');
    }
    #[On('offcanvascontrollerdismiss')]
    public function getData()
    {
        return InstagramService::orderBy(
            'counter_code',
            'DESC'
        )
            ->where(
                'type',
                InstagramServiceType::Like->value
            )
            ->search($this->filters['search'])
            ->customFilter($this->filters)
            ->withCount(
                ['instagramServiceItems as total_completed' => fn ($query) => $query->where(
                    'status',
                    'Completed'
                )]
            )
            ->withCount(
                ['instagramServiceItems as total_failed' => fn ($query) => $query->where(
                    'status',
                    InstagramServiceItemStatus::Failed->value
                )]
            )
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function render()
    {
        return view(
            'livewire.admin.instagram-service-report-management.like',
            [
                'data' => $this->getData(),
                'statuses' => InstagramServiceStatus::cases()
            ]
        )->title('Intagram Report - Like')->layout('layouts.admin.app');
    }
}
