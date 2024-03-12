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
            "username" => "admin_dev",
            "kode_prodi" => "D3MI",
            "nama" => "Admin Dev",
            "email" => "salimahmad14823@gmail.com",
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "role" => "super"
        ]);
        User::create([
            "username" => "mubassiran",
            "kode_prodi" => "D3MI",
            "nama" => "Mubassiran",
            "email" => "mubassiran@ulbi.ac.id",
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "role" => "super"
        ]);
        User::create([
            "username" => "admin_d3mi",
            "kode_prodi" => "D3MI",
            "nama" => "Staff D3 MI",
            "email" => "d3si@ulbi.ac.id",
            "password" => Hash::make("12345678"),
            "is_active" => true,
            "role" => "admin"
        ]);
    }
}
