<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
    'name',
    'email',
    'subject',
    'message',
    'is_replied',
    'replied_at',
    'reply_message'
];
}