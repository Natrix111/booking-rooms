<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            [
                'name' => 'Стандартный номер',
                'dimensions' => json_encode([5, 2, 4]),
                'amenities' => json_encode(['WiFi', 'TV']),
                'price' => 2000,
                'photos' => json_encode(['room1.jpg', 'room2.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Люкс с видом на море',
                'dimensions' => json_encode([5, 2, 6]),
                'amenities' => json_encode(['WiFi', 'TV', 'Minibar', 'Air Conditioning']),
                'price' => 5000,
                'photos' => json_encode(['lux1.jpg', 'lux2.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Семейный номер',
                'dimensions' => json_encode([7, 3, 6]),
                'amenities' => json_encode(['WiFi', 'TV', 'Kitchen']),
                'price' => 3000,
                'photos' => json_encode(['family1.jpg', 'family2.jpg']),
                'featured' => false,
            ],
            [
                'name' => 'Эконом-класс',
                'dimensions' => json_encode([4, 2, 3]),
                'amenities' => json_encode(['WiFi']),
                'price' => 1500,
                'photos' => json_encode(['economy1.jpg']),
                'featured' => false,
            ],
            [
                'name' => 'Двухместный номер',
                'dimensions' => json_encode([5, 2, 4]),
                'amenities' => json_encode(['WiFi', 'TV']),
                'price' => 2500,
                'photos' => json_encode(['double1.jpg', 'double2.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Трехместный номер',
                'dimensions' => json_encode([8, 3, 9]),
                'amenities' => json_encode(['WiFi', 'TV']),
                'price' => 3000,
                'photos' => json_encode(['triple1.jpg', 'triple2.jpg', 'triple3.jpg']),
                'featured' => false,
            ],
            [
                'name' => 'Президентский номер',
                'dimensions' => json_encode([7, 3, 5]),
                'amenities' => json_encode(['WiFi', 'TV', 'Minibar']),
                'price' => 6500,
                'photos' => json_encode(['president1.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Чиловый номер',
                'dimensions' => json_encode([5, 2, 5]),
                'amenities' => json_encode(['WiFi', 'TV']),
                'price' => 1500,
                'photos' => json_encode(['chill-1.jpg', 'chill-2.jpg',]),
                'featured' => false,
            ],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insert($room);
        }
    }
}
