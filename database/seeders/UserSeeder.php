<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "username"=> "akmalns28",
            "nama"=> "ANS",
            "email"=> "akmalnursidiq10@gmail.com",
            "password"=> Hash::make("12345678"),
            "terverifikasi"=> 1,
            "role"=> "super"
        ]);
        User::create([
            "username"=> "ahmdsalim",
            "nama"=> "Ahmad Salim",
            "email"=> "salimahmad14823@gmail.com",
            "password"=> Hash::make("12345678"),
            "terverifikasi"=> 1,
            "role"=> "super"
        ]);
        User::create([
            "username"=> "guest",
            "nama"=> "Guest Account",
            "email"=> "guest@gmail.com",
            "password"=> Hash::make("guest"),
            "terverifikasi"=> 1,
            "role"=> "admin"
        ]);
        
    }
}
