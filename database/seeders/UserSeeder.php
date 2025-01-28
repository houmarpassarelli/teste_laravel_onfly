<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => "Admin",
            'email' => "admin@teste.com",
            'password' => Hash::make('12345678'),
            'level' => "admin",
        ]);
    }
}
