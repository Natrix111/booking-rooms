<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{   
    protected $fillable = ['slogan','title','city'];
    public $timestamps = false;
}
