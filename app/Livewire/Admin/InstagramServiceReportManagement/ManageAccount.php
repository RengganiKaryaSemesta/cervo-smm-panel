<?php

namespace App\Livewire\Admin\InstagramServiceReportManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InstagramAccount;
use App\Traits\PaginationVariable;

class ManageAccount extends Component
{
    use WithPagination, PaginationVariable;
    public function getData()
    {
        return InstagramAccount::search($this->pagination['search'])
            ->byUser()->latest()
            ->paginate($this->pagination['limit'])->withQueryString();
    }
    public function render()
    {
        return view(
            'livewire.admin.instagram-service-report-management.manage-account',
            [
                'data' => $this->getData(),
            ]
        )->title('Report - Instagram Account Management')->layout('layouts.admin.app');
    }
}
