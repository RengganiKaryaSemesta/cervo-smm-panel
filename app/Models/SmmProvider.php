<?php

namespace App\Models;

use App\Models\Concern\Auditable;
use App\Models\Concern\CounterCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmmProvider extends Model
{
    use SoftDeletes, Auditable, CounterCode;
    protected $fillable = [
        'name',
        'api_url',
        'api_key',
    ];
    public function scopeSearch($query, $keywords)
    {
        return $query->where(
            'name',
            'LIKE',
            '%' . $keywords . '%'
        )->orWhere(
                'api_url',
                'LIKE',
                '%' . $keywords . '%'
            );
    }
}
