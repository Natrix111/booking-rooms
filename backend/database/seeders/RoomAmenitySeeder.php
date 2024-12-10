<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roomAmenities = [
            1 => [1, 2],
            2 => [2, 3],
            3 => [1, 4, 5],
            4 => [3, 4],
            5 => [1, 2, 3],
            6 => [4, 5],
            7 => [1, 3],
            8 => [2, 4],
        ];

        foreach ($roomAmenities as $roomId => $amenityIds) {
            foreach ($amenityIds as $amenityId) {
                DB::table('room_amenity')->insert([
                    'room_id' => $roomId,
                    'amenity_id' => $amenityId,
                ]);
            }
        }
    }
}
