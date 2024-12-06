<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $casts = [
        'social_links' => 'array',
    ];

    public $timestamps = false;
}
