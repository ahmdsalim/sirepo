<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sekolah::create([
        	'npsn' => '12345678',
        	'nama' => 'SMKN 99 Bandung',
        	'jenjang' => 'smk',
        	'alamat' => 'Jln. Soekarno Hatta No. 109',
        	'provinsi' => '32-JAWA BARAT',
        	'kota' => '3273-KOTA BANDUUNG',
        	'kecamatan' => '3273120-UJUNG BERUNG',
        	'kelurahan' => '3273120005-PASIR WANGI',
        	'telepon' => '02129271234'
        ]);
    }
}
