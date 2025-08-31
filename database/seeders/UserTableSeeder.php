<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'username' => 'user',
                'password' => Hash::make('123456789'),
                'role' => 'user',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'agent@gmail.com'],
            [
                'name' => 'Agent',
                'username' => 'agent',
                'password' => Hash::make('123456789'),
                'role' => 'agent',
                'status' => 'active',
            ]
        );
    }
}
