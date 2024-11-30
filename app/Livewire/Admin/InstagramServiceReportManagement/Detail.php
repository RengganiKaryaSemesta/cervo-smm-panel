<?php

namespace App\Livewire\Admin\InstagramServiceReportManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InstagramService;
use App\Traits\PaginationVariable;
use App\Enums\InstagramServiceType;
use App\Models\InstagramServiceItem;
use App\Enums\InstagramServiceStatus;

class Detail extends Component
{
    use WithPagination, PaginationVariable;
    public InstagramService $instagramService;
    public function getData()
    {
        return InstagramServiceItem::where(
            'instagram_service_id',
            $this->instagramService->id
        )
            ->with("instagramAccount")
            ->search($this->pagination['search'])
            ->customOrder($this->pagination)
            ->when(
                isset($this->pagination["filters_status"]) && $this->pagination["filters_status"],
                function ($query) {
                    return $query->where(
                        'status',
                        $this->pagination['filters_status']);
                })
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function render()
    {
        return view(
            'livewire.admin.instagram-service-report-management.detail',
            [
                'data'      => $this->getData(),
                'isComment' => $this->instagramService->type == InstagramServiceType::Comment,
                'type'      => strtolower($this->instagramService->type->value),
                'statuses'  => InstagramServiceStatus::cases(),
            ]
        )->title('Intagram Report - Detail ' . $this->instagramService->type->value)->layout('layouts.admin.app');
    }
}
