<?php

namespace MtSettings\LaravelSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value.
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        return self::decodeValue($setting->value);
    }
    
    /**
     * Set a setting value.
     */
    public static function set(string $key, $value): bool
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = is_array($value) ? json_encode($value) : $value;
        return $setting->save();
    }
    
    /**
     * Check if setting exists.
     */
    public static function has(string $key): bool
    {
        return static::where('key', $key)->exists();
    }
    
    /**
     * Get all settings.
     */
    public static function getAll(): array
    {
        $settings = [];
        foreach (static::all() as $setting) {
            $settings[$setting->key] = self::decodeValue($setting->value);
        }
        return $settings;
    }
    
    /**
     * Decode JSON value if needed.
     */
    private static function decodeValue($value)
    {
        $decoded = json_decode($value, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $value;
    }
}