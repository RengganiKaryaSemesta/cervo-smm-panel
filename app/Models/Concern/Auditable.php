<?php

namespace App\Models\Concern;

use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        // Ketika model dibuat
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id(); // Bisa langsung set updated_by juga
            }
        });

        // Ketika model di-update
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = Auth::id();
            }
        });
    }

    // Relasi ke model User
    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
    public function deletor()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by');
    }
}
