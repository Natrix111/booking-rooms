<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['address', 'working_hours', 'phone', 'email', 'social_links'];
    protected $casts = [
        'social_links' => 'array',
    ];

    public $timestamps = false;
}
