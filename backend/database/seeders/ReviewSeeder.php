<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {

            $user = User::inRandomOrder()->first();

            Review::create([
                'user_id' => $user->id,
                'content' => 'Отличный сервис! Мой питомец чувствовал себя как дома)',
                'author' => $user->name,
            ]);
        }
    }
}
