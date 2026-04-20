<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    protected $table = 'settings';

    public $timestamps = false;

    protected $fillable = ['key', 'value'];

    public static function get($key)
    {
        $row = DB::table('settings')->where('key', $key)->first();

        return $row ? $row->value : null;
    }
}