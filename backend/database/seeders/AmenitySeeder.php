<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('amenities')->insert([
            [
                'name' => 'TV',
                'img' => 'icons/TV.png'
            ],
            [
                'name'=> 'WiFi',
                'img'=>'icons/wifi.png'
            ],
            [
                'name'=> 'Minibar',
                'img'=>'icons/minibar.png'
            ],
            [
                'name'=> 'Air Conditioning',
                'img'=>'icons/airconditioning.png'
            ],
            [
                'name'=> 'Safe',
                'img'=>'icons/safe.png'
            ],
        ]);
    }
}
