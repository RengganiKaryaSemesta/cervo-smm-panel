<?php

namespace App\Models\Concern;

trait CounterCode
{
    /**
     * Create a new class instance.
     */
    public static function getLastCounterCode()
    {
        return self::withTrashed()->max('counter_code');
    }

    public static function createLastCode($counter_code, $model=null, $prefix = null)
    {
        // Jika dipanggil dari model, ambil prefix dari model, jika tidak gunakan $prefix dari argumen
        if($model != null){
            $prefix = $prefix ?? (property_exists($model, 'prefixCode') ? $model->prefixCode : '');
        }
        // Gabungkan prefix dengan kode yang sudah di-pad
        return $prefix . str_pad($counter_code, 5, '0', STR_PAD_LEFT);
    }
    public function getCodePrefix(): string
    {
        return ''; // Default tidak ada prefix
    }
    public static function bootCounterCode()
    {
        static::creating(function ($model) {
            // Set counter_code dari max yang ada saat ini
            $model->counter_code = self::getLastCounterCode() + 1;
            // Set kode jika tidak ada kode yang di-set secara manual
            if (!$model->code) {
                $model->code = self::createLastCode( $model->counter_code,$model);
            }
        });
    }
}
