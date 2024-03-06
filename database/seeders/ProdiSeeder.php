<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prodi::create([
            "nama_prodi" => "D3 Manajemen Informatika",
            "kode_prodi" => 30,
            "singkatan_prodi" => "D3 MI"
        ]);
    }
}
