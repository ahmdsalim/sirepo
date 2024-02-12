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
            "username"=> "admin",
            "nama"=> "Admin",
            "email"=> "super@gmail.com",
            "password"=> Hash::make("s"),
            "terverifikasi"=> 1,
            "role"=> "super"
        ]);
        User::create([
            "username"=> "adminANS",
            "nama"=> "ANS",
            "email"=> "ans@gmail.com",
            "password"=> Hash::make("wew"),
            "terverifikasi"=> 1,
            "role"=> "admin"
        ]);
        User::create([
            "username"=> "dadang.kornelo",
            "nama"=> "Dadang",
            "email"=> "dadangkornelo@gmail.com",
            "password"=> Hash::make("telolet"),
            "terverifikasi"=> 1,
            "role"=> "user"
        ]);
    }
}
