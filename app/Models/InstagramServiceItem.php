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
            $keywords != null,
            function (Builder $query) use ($keywords) {
                return $query->where(
                    function ($query) use ($keywords) {
                        return $query->where(
                            'error_msg',
                            'LIKE',
                            '%' . $keywords . '%'
                        )->orWhereHas('instagramAccount',function($query)use($keywords){
                            return $query->where('name',
                            'LIKE',
                            '%' . $keywords . '%');
                        })->orWhere('email',
                            'LIKE',
                            '%' . $keywords . '%');
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

    public function instagramAccount()
    {
        return $this->belongsTo(
            InstagramAccount::class,
            'instagram_account_id'
        );
    }
}
