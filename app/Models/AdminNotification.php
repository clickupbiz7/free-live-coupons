<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'url',
        'is_read'
    ];
}