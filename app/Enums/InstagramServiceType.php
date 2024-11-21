<?php

namespace App\Enums;

enum InstagramServiceType: string
{
    case Like    = 'Like';
    case Comment = 'Comment';
    case Follow  = 'Follow';
    public function label() : string
    {
        return match ($this) {
            self::Follow  => 'Follow',
            self::Like    => 'Like',
            self::Comment => 'Comment',
        };
    }
}
