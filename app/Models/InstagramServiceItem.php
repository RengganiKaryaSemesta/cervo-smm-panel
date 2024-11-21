<?php

namespace App\Models;

use App\Enums\InstagramServiceItemStatus;
use App\Enums\InstagramServiceType;
use App\Models\Concern\Auditable;
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
    ];
    protected function casts() : array
    {
        return [
            'status' => InstagramServiceItemStatus::class,
            'type'   => InstagramServiceType::class,
        ];
    }
    public function instagramService()
    {
        return $this->belongsTo(InstagramService::class, 'instagram_service_id');
    }

    public function instagramAccount()
    {
        return $this->belongsTo(
            InstagramAccount::class,
            'instagram_account_id'
        );
    }
}
