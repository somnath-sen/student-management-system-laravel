<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $value = strtolower($setting->value);
            if ($value === 'true') return true;
            if ($value === 'false') return false;
            return $setting->value;
        }
        
        return $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function set($key, $value)
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );
    }
}
