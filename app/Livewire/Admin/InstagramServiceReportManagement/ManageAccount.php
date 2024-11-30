<?php

namespace App\Livewire\Admin\InstagramServiceReportManagement;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\InstagramAccount;
use App\Traits\PaginationVariable;

class ManageAccount extends Component
{
    use WithPagination, PaginationVariable;
    #[Url]
    public $filters = [
        'status'    => NULL,
        'creator'   => NULL,
        'startDate' => NULL,
        'endDate'   => NULL,
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
        return InstagramAccount::search($this->pagination['search'])
            ->byUser()->filterRange($this->filters)
            ->when(
                $this->filters['status'] != "",
                fn ($q) => $q->where(
                    'status',
                    $this->filters['status']
                )
            )
            ->when(
                $this->filters['creator'] != "",
                fn ($q) => $q->where(
                    'created_by',
                    $this->filters['creator']
                )
            );
    }
    public function render()
    {
        return view(
            'livewire.admin.instagram-service-report-management.manage-account',
            [
                'data'    => $this->getData()
                    ->customSingleOrders($this->pagination)->paginate($this->pagination['limit'])->withQueryString(),
                'creator' => User::whereHas(
                    'roles',
                    fn ($q) => $q->where(
                        'name',
                        'Admin'
                    )
                )->get(),
                'totals'  => $this->getData()->selectRaw(
                    'SUM(CASE WHEN status = true THEN 1 ELSE 0 END) as Active, 
                 SUM(CASE WHEN status = false THEN 1 ELSE 0 END) as Inactive'
                )->first(),
            ]
        )->title('Report - Instagram Account Management')->layout('layouts.admin.app');
    }
}
