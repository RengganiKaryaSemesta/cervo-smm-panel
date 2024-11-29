<?php

namespace App\Enums;

enum SmmProviderServiceType: string
{
    case CustomComments = "Custom Comments";
    case Package        = "Package";
    case CommentLikes   = "CommentLikes";
    case Default        = "Default";
    case Subscriptions  = "Subscriptions";
    public function getComponent() : string
    {
        return match ($this) {
            self::Default        => "default1",
            self::Subscriptions  => "subscriptions",
            self::CustomComments => "custom-comments",
            self::CommentLikes   => "comment-likes",
            self::Package        => "package",
        };
    }
}
