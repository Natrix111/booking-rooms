<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'img'];
    protected $table = 'amentities';
    public $timestamps = false;
}
