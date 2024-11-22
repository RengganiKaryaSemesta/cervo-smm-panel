<?php

namespace App\Livewire\Admin\InstagramServiceReportManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InstagramService;
use App\Traits\PaginationVariable;
use App\Enums\InstagramServiceType;
use App\Models\InstagramServiceItem;

class Detail extends Component
{
    use WithPagination, PaginationVariable;
    public InstagramService $instagramService;
    public function getData()
    {
        return InstagramServiceItem::latest()
            ->where(
                'instagram_service_id',
                $this->instagramService->id
            )
            ->search($this->pagination['search'])
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function render()
    {
        return view(
            'livewire.admin.instagram-service-report-management.detail',
            [
                'data' => $this->getData(),
                'isComment'=>$this->instagramService->type == InstagramServiceType::Comment,
                'type' => strtolower($this->instagramService->type->value)
            ]
        )->title('Intagram Report - Detail')->layout('layouts.admin.app');
    }
}
