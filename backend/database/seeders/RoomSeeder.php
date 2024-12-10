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
                'price' => 2000,
                'photos' => json_encode(['rooms/standart-1.jpg', 'rooms/standart-2.jpg', 'rooms/standart-3.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Люкс с видом на море',
                'dimensions' => json_encode([5, 2, 6]),
                'price' => 5000,
                'photos' => json_encode(['rooms/lux-1.jpg', 'rooms/lux-2.jpg', 'rooms/lux-3.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Семейный номер',
                'dimensions' => json_encode([7, 3, 6]),
                'price' => 3000,
                'photos' => json_encode(['rooms/family-1.jpg', 'rooms/family-2.jpg', 'rooms/family-3.jpg']),
                'featured' => false,
            ],
            [
                'name' => 'Эконом-класс',
                'dimensions' => json_encode([4, 2, 3]),
                'price' => 1500,
                'photos' => json_encode(['rooms/economy-1.jpg', 'rooms/economy-2.jpg', 'rooms/economy-3.jpg']),
                'featured' => false,
            ],
            [
                'name' => 'Двухместный номер',
                'dimensions' => json_encode([5, 2, 4]),
                'price' => 2500,
                'photos' => json_encode(['rooms/double-1.jpg', 'rooms/double-2.jpg', 'rooms/double-3.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Трехместный номер',
                'dimensions' => json_encode([8, 3, 9]),
                'price' => 3000,
                'photos' => json_encode(['rooms/triple-1.jpg', 'rooms/triple-2.jpg', 'rooms/triple-3.jpg']),
                'featured' => false,
            ],
            [
                'name' => 'Президентский номер',
                'dimensions' => json_encode([7, 3, 5]),
                'price' => 6500,
                'photos' => json_encode(['rooms/president-1.jpg', 'rooms/president-2.jpg', 'rooms/president-3.jpg']),
                'featured' => true,
            ],
            [
                'name' => 'Чиловый номер',
                'dimensions' => json_encode([5, 2, 5]),
                'price' => 1500,
                'photos' => json_encode(['rooms/chill-1.jpg', 'rooms/chill-2.jpg', 'rooms/chill-3.jpg']),
                'featured' => false,
            ],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insert($room);
        }
    }
}
