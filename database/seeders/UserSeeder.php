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
            "username" => "akmalns28",
            "kode_prodi" => "D3MI",
            "nama" => "ANS",
            "email" => "akmalnursidiq10@gmail.com",
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "role" => "super"
        ]);
        User::create([
            "username" => "ahmdsalim",
            "kode_prodi" => "D3MI",
            "nama" => "Ahmad Salim",
            "email" => "salimahmad14823@gmail.com",
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "role" => "super"
        ]);
        User::create([
            "username" => "guest",
            "kode_prodi" => "D3MI",
            "nama" => "Guest Account",
            "email" => "guest@gmail.com",
            "password" => Hash::make("guest"),
            "is_active" => true,
            "role" => "admin"
        ]);
    }
}
