<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ActivityLog extends \Spatie\Activitylog\Models\Activity
{
    protected $table = 'activity_log';
    public function scopeCustomSingleOrders(Builder $query, $order)
    {
        if (isset($order['order'][0])) {
            $path      = $order['order'][0];
            $direction = strtolower($order['order'][1]);

            if (\Str::contains(
                $path,
                '.')) {
                //    left join ke table user dari table activity_log dan order berdasarkan user.name direction ambil dari variable
                $query->select("*");
                $query->leftJoin(
                    'users',
                    'activity_log.causer_id',
                    '=',
                    'users.id')
                    ->addSelect("users.name as user_name")
                    ->orderBy(
                        "user_name",
                        $direction);
            }
            else {
                $query->orderBy(
                    $path,
                    $direction);
            }
        }

        return $query;
    }
}
