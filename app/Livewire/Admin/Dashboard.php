<?php

namespace App\Livewire\Admin;

use App\Enums\InstagramServiceType;
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
            'total_like' => InstagramServiceItem::selectRaw('SUM(CASE WHEN status = "Completed" THEN 1 ELSE 0 END) as Completed, SUM(CASE WHEN status = "Failed" THEN 1 ELSE 0 END) as Failed')->first(),
            'total_coment' => InstagramServiceItem::whereNotNull('comment')->count(),
            'total_follow' => InstagramServiceItem::where('type', InstagramServiceType::Follow->value)->count(),
        ])->title('Dashboard')->layout('layouts.admin.app');
    }
}
