<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'address' => 'Томск, ул. Ленина, 1',
                'working_hours' => 'Пн-Пт: 09:00 - 18:00',
                'phone' => '+7-495 123 45 67',
                'email' => 'info@koteyka.com',
                'social_links' => json_encode([
                    'facebook' => 'https://facebook.com/koteyka',
                    'vk' => 'https://vk.com/koteyka',
                    'instagram' => 'https://instagram.com/koteyka',
                ]),
            ]
        ]);
    }
}
