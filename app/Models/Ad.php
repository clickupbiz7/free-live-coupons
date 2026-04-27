<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'title',
        'network',
        'placement',
        'size',
        'device',
        'priority',
        'ad_code',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status',1)
                     ->orderBy('priority','ASC')
                     ->orderBy('id','DESC');
    }
}