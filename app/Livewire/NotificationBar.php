<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationBar extends Component
{
    #[On('notify:refresh')]
    public function handleRefreshData()
    {
        $data = $this->getData();
        $this->dispatch('notify:refresh-data', total: $data['unread_data']->count())->self();
    }
    public function getData()
    {
        $user = User::with(['unreadNotifications', 'notifications'])->find(auth()->id());
        return [
            'unread_data' => $user->unreadNotifications,
            'data' => $user->notifications->groupBy(function ($notification) {
                $createdAt = Carbon::parse($notification->created_at);
                if ($createdAt->isToday()) {
                    return 'Today';
                } elseif ($createdAt->isYesterday()) {
                    return 'Yesterday';
                } else {
                    return $createdAt->format('F j, Y');
                }
            }),
        ];
    }
    public function clearAll()
    {
        auth()->user()->notifications->each(function ($notification) {
            $notification->delete();
        });
    }
    public function render()
    {
        return view('livewire.notification-bar', $this->getData());
    }
}
