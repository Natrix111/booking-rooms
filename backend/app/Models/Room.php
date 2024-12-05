<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'dimensions',
        'price',
        'photos',
        'featured',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'photos' => 'array',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenity', 'room_id', 'amenity_id');
    }
    public function getSquare()
    {
        $dimensions = $this->dimensions;
        return $dimensions[0] * $dimensions[1];
    }

    public $timestamps = false;
}
