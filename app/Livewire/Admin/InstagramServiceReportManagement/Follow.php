<?php

namespace App\Livewire\Admin\InstagramServiceReportManagement;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\InstagramService;
use App\Traits\PaginationVariable;
use App\Enums\InstagramServiceType;
use App\Enums\InstagramServiceStatus;
use App\Enums\InstagramServiceItemStatus;

class Follow extends Component
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
    public function getData()
    {
        return InstagramService::where(
                'type',
                InstagramServiceType::Follow->value
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
            ->customOrder($this->pagination)
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function render()
    {
        return view(
            'livewire.admin.instagram-service-report-management.follow',
            [
                'data' => $this->getData(),
                'statuses' => InstagramServiceStatus::cases()
            ]
        )->title('Intagram Report - Follow')->layout('layouts.admin.app');
    }
}
