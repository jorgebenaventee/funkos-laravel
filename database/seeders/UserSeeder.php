<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin'
        ]);


        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('user1234'),
            'role' => 'user'
        ]);
    }
}
