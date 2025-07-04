<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Sarah Gaming',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pro Gamer',
                'email' => 'progamer@example.com',
                'password' => Hash::make('password'),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}