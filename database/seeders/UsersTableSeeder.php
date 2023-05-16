<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            "first_name" => "Super",
            "last_name" => "Admin",
            "email" => "admin@app.com",
            "password" => Hash::make("123456789"),
        ]);
        $user->attachRole("super_admin");
    }
}
