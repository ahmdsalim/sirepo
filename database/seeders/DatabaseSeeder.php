<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(\Database\Seeders\SekolahSeeder::class);
        $this->call(\Database\Seeders\SiswaSeeder::class);
        $this->call(\Database\Seeders\UserSeeder::class);
    }
}
