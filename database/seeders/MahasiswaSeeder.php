<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            "npm" => "2213001",
            "kode_prodi" => "D3MI",
            "nama_mahasiswa" => "Azra",
            "email" => "azra@gmail.com",
            "is_active" => false
        ]);
        Mahasiswa::create([
            "npm" => "2213013",
            "kode_prodi" => "D3MI",
            "nama_mahasiswa" => "Viki Eka",
            "email" => "vikimantep@gmail.com",
            "is_active" => false
        ]);
    }
}
