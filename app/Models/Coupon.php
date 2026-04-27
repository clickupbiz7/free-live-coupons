<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $fillable = [
        'title',
        'slug',
        'code',
        'discount',
        'type',
        'store_id',
        'category_id',
        'expiry_date',
        'description',
        'image',
        'status',
        'affiliate_link',
        'featured',
        'badge'
    ];

    protected $casts = [
        'status' => 'integer',
        'featured' => 'integer'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}