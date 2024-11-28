<?php

namespace App\Enums;

enum SmmProviderServiceType: string
{
    case Subscriptions = "Subscriptions";
    public function fields() : array
    {
        return match ($this) {
            self::Subscriptions => [
                'username',
                'min',
                'max',
                'posts',
                'old_posts',
                'delay',
            ],
        };
    }
    public function formBlade()
    {
        return match ($this) {
            self::Subscriptions => view('livewire.admin.other-service-management.fields.Subscriptions')->render()
        };
    }
    public function details()
    {
        return match ($this) {
            self::Subscriptions => view('livewire.admin.other-service-management.details.Subscriptions')->render()
        };
    }
}
