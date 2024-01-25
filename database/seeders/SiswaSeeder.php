<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::create([
        	'nisn' => '1234567890',
        	'nama' => 'Rizqul Padang',
        	'jk' => 'L',
        	'telepon' => '08123456789',
        	'npsn' => '12345678'
        ]);
    }
}
