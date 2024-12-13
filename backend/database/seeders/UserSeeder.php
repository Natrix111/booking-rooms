<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
    DB::table('users')->insert([
        [
            'name' => 'Иван Иванов',
            'email' => 'ivanov@gmail.com',
            'phone' => '8-123-456-78-90',
            'password' => bcrypt('QWEasd123'),
            'role'=> 'client',
            'avatar' => 'avatars/avatar-1.png',
        ],
        [
            'name' => 'Екатерина Петрова',
            'email' => 'petrova@example.com',
            'phone' => '8-999-654-32-10',
            'password' => bcrypt('ASDqwe321'),
            'role'=> 'client',
            'avatar' => 'avatars/avatar-2.png',
        ],
        [
            'name' => 'Администратор Первый',
            'email' => 'Admin@admin.com',
            'phone' => '8-999-999-99-99',
            'password' => bcrypt('superAdmin'),
            'role'=> 'admin',
            'avatar' => 'avatars/avatar-3.png',
        ],
    ]);
}

}
