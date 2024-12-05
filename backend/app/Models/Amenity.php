<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'img'];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_amenity', 'amenity_id', 'room_id');
    }

    public $timestamps = false;
}
