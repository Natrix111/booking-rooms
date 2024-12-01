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
        'amenities',
        'price',
        'photos',
        'featured',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'amenities' => 'array',
        'photos' => 'array',
    ];

    public function getSquare()
    {
        $dimensions = $this->dimensions;
        return $dimensions[0] * $dimensions[1];
    }

    public function getAmenities()
    {
        return $this->amenities ?? [];
    }
}
