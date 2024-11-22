<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Concern\Auditable;
use App\Enums\InstagramServiceType;
use App\Models\Concern\CounterCode;
use App\Enums\InstagramServiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model untuk layanan Instagram
 */
class InstagramService extends Model
{
    use SoftDeletes, Auditable, CounterCode;

    /**
     * Atribut yang dapat diisi oleh pengguna
     *
     * @var array
     */
    protected $fillable = [
        'url', // URL layanan Instagram
        'account_count', // Jumlah akun yang terhubung
        'type', // Tipe layanan (misal: posting, story, dll)
        'status', // Status layanan (misal: aktif, tidak aktif)
        'started_at', // Waktu mulai layanan
        'finished_at', // Waktu selesai layanan
        "error_msg",
    ];

    /**
     * Atribut yang dapat di-casting ke tipe tertentu
     *
     * @return array
     */
    protected function casts() : array
    {
        return [
            'started_at'  => 'datetime', // Casting atribut started_at ke tipe datetime
            'finished_at' => 'datetime', // Casting atribut finished_at ke tipe datetime
            'status'      => InstagramServiceStatus::class,
            'type'        => InstagramServiceType::class,
        ];
    }
    public function scopeSearch($query,$keywords){
        return $query->when($keywords!=null,function($query)use($keywords){
            return $query->where(function($query)use($keywords){
                return $query->where(
                    'url',
                    'LIKE',
                    '%' . $keywords . '%'
                )->orWhere(
                        'error_msg',
                        'LIKE',
                        '%' . $keywords . '%'
                );
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
                            'started_at',
                            [
                                $startDate,
                                $endDate,
                            ]
                        )
                            ->orWhereBetween(
                                'finished_at',
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
    public function instagramServiceItems()
    {
        return $this->hasMany(
            InstagramServiceItem::class,
            'instagram_service_id'
        );
    }
}
