<?php

namespace App\Helpers;

class CleanMaskDecimal
{
    /**
     * Create a new class instance.
     */

    public static function cleanInput(string $value): string
    {
        if ($value) {
            $value = floatval(str_replace(['.', ','], ['', '.'], $value));
        }
        return $value;
    }
    public static function cleanRead(string $value): string
    {
        if ($value) {
            $value = number_format($value, 2, ',', '.');
        }
        return $value;
    }
    public static function getReadableCapacity(float $quantity, string $unitType = 'weight'): array
    {
        return [
            'value' => self::cleanRead($quantity / 1000),
            'code' => $unitType == 'weight' ? 'kg' : 'L'
        ];
    }
    public static function convert($quantity, $type = 'weight', $toLower = true): float
    {
        if ($toLower) {
            return match ($type) {
                'weight' => self::convertKgToGrams($quantity),
                default => self::convertLitersToMilliliters($quantity),
            };
        }
        return match ($type) {
            'weight' => self::convertGramsToKg($quantity),
            default => self::convertMillilitersToLiters($quantity),
        };
    }
    public static function convertKgToGrams($kilograms): float
    {
        return $kilograms * 1000; // 1 kg = 1000 gram
    }
    public static function convertGramsToKg($grams): float
    {
        return $grams / 1000; // 1 kg = 1000 gram
    }
    public static function convertMillilitersToLiters($milliliters): float
    {
        return $milliliters / 1000; // 1 kg = 1000 gram
    }

    public static function convertLitersToMilliliters($liters): float
    {
        // Mengonversi liter ke mililiter
        return $liters * 1000; // 1 liter = 1000 mililiter
    }
}
