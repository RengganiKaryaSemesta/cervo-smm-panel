<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Concern\Auditable;
use App\Models\Concern\CounterCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmmProviderOrder extends Model
{
    use SoftDeletes, Auditable, CounterCode;
    protected $fillable = [
        'order_id',
        'smm_provider_id',
        'service',
        'status',
        'target',
        'start_count',
        'remains',
        'charge',
    ];
    public function smmProvider()
    {
        return $this->belongsTo(SmmProvider::class);
    }
    public function scopeSearch($query, $keywords)
    {
        return $query->where(
            'smm_provider_orders.service',
            'LIKE',
            '%' . $keywords . '%'
        )->orWhere(
                'smm_provider_orders.order_id',
                'LIKE',
                '%' . $keywords . '%'
            )->orWhere(
                function (Builder $query) use ($keywords) {
                    return $query->whereHas(
                        "creator",
                        function ($query) use ($keywords) {
                            return $query->where(
                                'name',
                                'LIKE',
                                '%' . $keywords . '%');
                        });
                });
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
                            'smm_provider_orders.created_at',
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

                    $query->leftJoin(
                        $relatedTable,
                        "{$table}.{$foreignKey}",
                        '=',
                        "{$relatedTable}.id")
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
}
