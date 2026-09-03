<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        $val = $setting ? $setting->value : $default;

        if (is_string($val)) {
            $val = str_ireplace('hand-crafted', 'crafted', $val);
            $val = str_ireplace('handcrafted', 'crafted', $val);
        }

        return $val;
    }

    public static function set($key, $value, $group = 'general', $type = 'text')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type]
        );
    }
}
