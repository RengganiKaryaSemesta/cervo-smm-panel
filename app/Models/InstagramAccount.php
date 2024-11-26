<?php

namespace App\Models;

use App\Models\Concern\Auditable;
use App\Models\Concern\CounterCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
        $roles = auth()->user()->roles->pluck('name')->toArray();
        return $query->when(
            !in_array(
                'SuperAdmin',
                $roles
            ),
            function (Builder $query)  {
                return $query->where(
                    'created_by',
                    auth()->id()
                );
            }
        );
    }
    public function instagramServiceItems()
    {
        return $this->hasMany(
            InstagramServiceItem::class,
            'instagram_account_id'
        );
    }
}
