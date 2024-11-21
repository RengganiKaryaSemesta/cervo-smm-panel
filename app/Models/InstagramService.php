<?php

namespace App\Models;

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
    public function instagramServiceItems()
    {
        return $this->hasMany(InstagramServiceItem::class, 'instagram_service_id');
    }
}
