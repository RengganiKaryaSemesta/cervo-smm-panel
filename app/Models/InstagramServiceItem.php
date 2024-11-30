<?php

namespace App\Models;

use App\Enums\InstagramServiceItemStatus;
use App\Enums\InstagramServiceType;
use App\Models\Concern\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstagramServiceItem extends Model
{
    use SoftDeletes, Auditable;
    protected $fillable = [
        'instagram_account_id',
        'instagram_service_id',
        'comment',
        'type',
        'status',
        "error_msg",
    ];
    protected function casts() : array
    {
        return [
            'status' => InstagramServiceItemStatus::class,
            'type'   => InstagramServiceType::class,
        ];
    }
    public function scopeSearch($query, $keywords)
    {
        return $query->when(
            $keywords != NULL,
            function (Builder $query) use ($keywords) {
                return $query->where(
                    function ($query) use ($keywords) {
                        return $query->where(
                            'error_msg',
                            'LIKE',
                            '%' . $keywords . '%'
                        )->orWhereHas(
                                'instagramAccount',
                                function ($query) use ($keywords) {
                                    return $query->where(
                                        'email',
                                        'LIKE',
                                        '%' . $keywords . '%');
                                });
                    }
                );
            }
        );
    }
    public function instagramService()
    {
        return $this->belongsTo(
            InstagramService::class,
            'instagram_service_id'
        );
    }
    public function scopeCustomOrder(Builder $query, $order)
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

                    // Lakukan join bertingkat untuk relasi
                    $query->leftJoin(
                        $relatedTable,
                        "{$table}.{$foreignKey}",
                        '=',
                        "{$relatedTable}.id")
                        ->addSelect("{$relatedTable}.{$column}");

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


    public function instagramAccount()
    {
        return $this->belongsTo(
            InstagramAccount::class,
            'instagram_account_id'
        );
    }
}
