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
            "npm" => "2213012",
            "kode_prodi" => "D3MI",
            "nama_mahasiswa" => "Budi Kustanto",
            "email" => "budi@gmail.com",
            "is_active" => true
        ]);
    }
}
