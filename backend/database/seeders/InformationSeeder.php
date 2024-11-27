<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('information')->insert([
            [
                'title' => 'Гостиница "Котейка"',
                'slogan' => 'Домашний уют для ваших питомцев',
                'city' => 'Москва',
            ]
        ]);
    }
}
