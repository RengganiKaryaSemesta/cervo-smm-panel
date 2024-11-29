<?php

namespace App\Enums;

enum SmmProviderServiceType: string
{
    case CustomComments = "CustomComments";
    case Package = "Package";
    case CommentLikes = "CommentLikes";
    case Default = "Default";
    case Subscriptions = "Subscriptions";
    public function getComponent():string{
        return match ($this){
            self::Default => "default1",
            self::Subscriptions => "subscriptions",
        };
    }
}
