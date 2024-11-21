<?php

namespace App\Enums;

enum InstagramServiceStatus: string
{
    case InProgress     = 'In Progress';
    case Completed      = 'Completed';
    case Failed         = 'Failed';
    case PartialFailure = 'partial_failure';
    public function label() : string
    {
        return match ($this) {
            self::PartialFailure => 'Partial Failure',
                // self::WaitingApproval => 'Waiting Approval',
                // self::Approved => 'Approved',
            self::InProgress     => 'In Progress',
            self::Completed      => 'Completed',
            self::Failed         => 'Failed',
        };
    }
    public function cssClass() : string
    {
        return match ($this) {
            self::PartialFailure => 'bg-yellow-300/10 text-yellow-700',
                // self::WaitingApproval => 'bg-orange-300/10 text-orange-700',
                // self::Approved => 'bg-purple-300/10 text-purple-700',
            self::InProgress     => 'bg-blue-300/10 text-blue-700',
            self::Completed      => 'bg-green-300/10 text-green-700',
            self::Failed         => 'bg-red-300/10 text-red-700',
        };
    }
}
