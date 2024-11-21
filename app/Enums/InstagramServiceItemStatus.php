<?php

namespace App\Enums;

enum InstagramServiceItemStatus: string
{
    case Completed      = 'Completed';
    case Failed         = 'Failed';
    public function label() : string
    {
        return match ($this) {
            self::Completed      => 'Completed',
            self::Failed         => 'Failed',
        };
    }
    public function cssClass() : string
    {
        return match ($this) {
            self::Completed      => 'bg-green-300/10 text-green-700',
            self::Failed         => 'bg-red-300/10 text-red-700',
        };
    }
}
