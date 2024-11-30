<?php

namespace App\Livewire\Admin\LogActivity;

use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Session;
use App\Traits\PaginationVariable;

class Content extends Component
{
    use WithPagination, PaginationVariable;
    public function delete()
    {
        try {
            \DB::beginTransaction();
            $this->getData()->delete();
            \DB::commit();
        }
        catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getData()
    {
        return ActivityLog::where(
            'log_name',
            'LIKE',
            '%' . $this->pagination['search'] . '%'
        )
            ->orWhere(
                'description',
                'LIKE',
                '%' . $this->pagination['search'] . '%'
            )->customSingleOrders($this->pagination);
    }
    public function render()
    {
        return view(
            'livewire.admin.log-activity.content',
            [
                'activities' => $this->getData()->paginate($this->pagination['limit'])->withQueryString(),
            ]
        )->title('Log Activity')->layout('layouts.admin.app');
    }
}
