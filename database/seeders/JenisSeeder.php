<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jenis::create([
            "nama_jenis"=> "Proyek 1",
        ]);
        Jenis::create([
            "nama_jenis"=> "Proyek 2",
        ]);
        Jenis::create([
            "nama_jenis"=> "PKL",
        ]);
        Jenis::create([
            "nama_jenis"=> "Tugas Akhir",
        ]);
    }
}
