<?php

namespace App\Models;

use App\Models\Concern\Auditable;
use App\Models\Concern\CounterCode;
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
    public function scopeSearch($query,$keywords){
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
}
