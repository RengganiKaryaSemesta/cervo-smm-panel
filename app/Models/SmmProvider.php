<?php

namespace App\Models;

use App\Models\Concern\Auditable;
use App\Models\Concern\CounterCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SmmProvider extends Model
{
    use SoftDeletes, Auditable, CounterCode;
    protected $fillable = [
        'name',
        'api_url',
        'api_key',
        'service_currency_code',
    ];
    public function scopeSearch($query, $keywords)
    {
        return $query->where(
            'name',
            'LIKE',
            '%' . $keywords . '%'
        )->orWhere(
                'api_url',
                'LIKE',
                '%' . $keywords . '%'
            );
    }
    public function orders()
    {
        return $this->hasMany(
            SmmProviderOrder::class,
            'smm_provider_id'
        );
    }
    public function scopeCustomFilters(Builder $query, array $filters)
    {
        return $query->when(
            $filters["filters_by_deleted"],
            function ($query) use ($filters) {
                return $filters["filters_by_deleted"] == "deleted"
                    ? $query->whereNotNull("deleted_at")
                    : $query->whereNull("deleted_at");
            });
    }
    public function scopeCustomSingleOrders(Builder $query, array $order)
    {
        if (isset($order["order"][0])) {
            return $query->orderBy(
                $order["order"][0],
                strtolower($order["order"][1]));
        }
    }
}
