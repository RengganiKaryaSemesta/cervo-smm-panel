<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Concern\Auditable;
use App\Models\Concern\CounterCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstagramAccount extends Model
{
    use SoftDeletes, Auditable;
    protected $fillable = [
        "username",
        "email",
        "password",
        "cookie",
        "status",
    ];
    public function scopeSearch($query, $keywords)
    {
        return $query->where(
            'username',
            'LIKE',
            '%' . $keywords . '%'
        )->orWhere(
                'email',
                'LIKE',
                '%' . $keywords . '%'
            );
    }
    // saya ingin membuat scope agar dibatasi data yang bisa dilihat hanya data yang dibuat oleh user yang login apa nama fungsi yang bagus
    public function scopeByUser($query)
    {
        $roles           = auth()->user()->roles->pluck('name')->toArray();
        $restrictedRoles = [
            'Super Admin',
        ];
        return $query->when(
            ! array_intersect(
                $restrictedRoles,
                $roles
            ),
            function (Builder $query) {
                return $query->where(
                    'created_by',
                    auth()->id()
                );
            }
        );
    }
    public function scopeFilterRange($query, array $filters)
    {
        $startDate = Carbon::parse($filters['startDate'])->startOfDay()->format('Y-m-d H:i');
        $endDate   = Carbon::parse($filters['endDate'])->endOfDay()->format('Y-m-d H:i');
        return $query->where(
            function ($query) use ($startDate, $endDate) {
                return $query->when(
                    $startDate && $endDate,
                    function ($query) use ($startDate, $endDate) {
                        return $query->whereBetween(
                            'updated_at',
                            [
                                $startDate,
                                $endDate,
                            ]
                        );
                    }
                );
            }
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
    public function instagramServiceItems()
    {
        return $this->hasMany(
            InstagramServiceItem::class,
            'instagram_account_id'
        );
    }
}
