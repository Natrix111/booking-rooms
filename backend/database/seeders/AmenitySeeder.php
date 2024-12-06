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
        DB::table('amentities')->insert([
            [
                'name' => 'TV',
                'img' => 'TV.png'
            ],
            [
                'name'=> 'WiFi',
                'img'=>'wifi.png'
            ]
        ]);
    }
}
