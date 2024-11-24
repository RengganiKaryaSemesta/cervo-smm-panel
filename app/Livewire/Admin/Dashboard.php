<?php

namespace App\Livewire\Admin;

use App\Enums\InstagramServiceType;
use App\Models\InstagramAccount;
use App\Models\InstagramServiceItem;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\ServiceReport;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class Dashboard extends Component
{

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'total_like' => InstagramServiceItem::selectRaw(
                'SUM(CASE WHEN status = "Completed" THEN 1 ELSE 0 END) as Completed, 
                 SUM(CASE WHEN status = "Failed" THEN 1 ELSE 0 END) as Failed'
            )->first(),
            'total_coment' => InstagramServiceItem::selectRaw(
                'SUM(CASE WHEN status = "Completed" AND comment IS NOT NULL THEN 1 ELSE 0 END) as Completed, 
                 SUM(CASE WHEN status = "Failed" AND comment IS NOT NULL THEN 1 ELSE 0 END) as Failed'
            )->first(),
            'total_follow' => InstagramServiceItem::selectRaw(
                'SUM(CASE WHEN status = "Completed" AND type = ? THEN 1 ELSE 0 END) as Completed, 
                 SUM(CASE WHEN status = "Failed" AND type = ? THEN 1 ELSE 0 END) as Failed',
                [InstagramServiceType::Follow->value, InstagramServiceType::Follow->value]
            )->first(),
            'total_accounts' => InstagramAccount::selectRaw(
                'SUM(CASE WHEN status = true THEN 1 ELSE 0 END) as Active, 
                 SUM(CASE WHEN status = false THEN 1 ELSE 0 END) as Inactive'
            )->first(),
        ])->title('Dashboard')->layout('layouts.admin.app');
    }
}
