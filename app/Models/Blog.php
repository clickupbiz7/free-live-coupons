<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\BlogCategory;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('uploads/blogs/' . $this->image))) {
            return asset('uploads/blogs/' . $this->image);
        }

        return asset('uploads/no-image.png');
    }

    public function getShortContentAttribute()
    {
        return Str::limit(strip_tags($this->content), 140);
    }

    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getCategoryNameAttribute()
    {
        return optional($this->category)->name ?? 'Uncategorized';
    }
}