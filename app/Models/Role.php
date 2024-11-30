<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Role extends \Spatie\Permission\Models\Role
{
    public function scopeCustomSingleOrders(Builder $query, $order)
    {
        if (isset($order['order'][0])) {
            $path      = $order['order'][0];
            $direction = strtolower($order['order'][1]);
            $query->orderBy(
                $path,
                $direction);
        }
        return $query;
    }
}
