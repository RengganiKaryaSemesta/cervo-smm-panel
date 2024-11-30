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
            'instagram_accounts.username',
            'LIKE',
            '%' . $keywords . '%'
        )->orWhere(
                'instagram_accounts.email',
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
                    'instagram_accounts.created_by',
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
                            'instagram_accounts.updated_at',
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
    public function scopeCustomSingleOrders(Builder $query, $order)
    {
        if (isset($order['order'][0])) {
            $path      = $order['order'][0];
            $direction = strtolower($order['order'][1]);

            if (\Str::contains(
                $path,
                '.')) {
                // Pisahkan relasi dan kolom untuk menangani join bertingkat
                $relations = explode(
                    '.',
                    $path);
                $column    = array_pop($relations); // Kolom yang akan diurutkan
                $table     = $query->getModel()->getTable(); // Tabel utama (misalnya: users)
                $query->select("{$table}.*");
                // Lakukan join untuk setiap relasi yang ada
                foreach ($relations as $relation) {
                    // Dapatkan nama tabel terkait untuk relasi
                    $relatedModel = $query->getModel()->{$relation}();
                    $relatedTable = $relatedModel->getRelated()->getTable();
                    $foreignKey   = $relatedModel->getForeignKeyName();

                    $query->leftJoin($relatedTable, "{$table}.{$foreignKey}", '=', "{$relatedTable}.id")
                    ->addSelect("{$relatedTable}.{$column} AS {$relatedTable}_{$column}");
                    // Update tabel utama untuk join berikutnya
                    $table = $relatedTable;
                }
                // Setelah semua join, lakukan orderBy pada kolom yang diinginkan
                $query->orderBy(
                    "{$table}.{$column}",
                    $direction);
            }
            else {
                // Jika tidak ada relasi, lakukan pengurutan biasa
                $query->orderBy(
                    $path,
                    $direction);
            }
        }

        return $query;
    }
    public function instagramServiceItems()
    {
        return $this->hasMany(
            InstagramServiceItem::class,
            'instagram_account_id'
        );
    }
}
