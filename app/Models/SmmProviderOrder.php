<?php

namespace App\Models;

use App\Models\Concern\Auditable;
use App\Models\Concern\CounterCode;
use Illuminate\Database\Eloquent\Model;
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
        'charge'
    ];
    public function smmProvider(){
        return $this->belongsTo(SmmProvider::class);
    }
}
