<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportSiswa implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{

    use Exportable;
    
    public function query(){
        return Siswa::query()->where('npsn',auth()->user()->userable->npsn);

    }

    public function map($siswa): array
    {
     return [
        $siswa->nisn,
        $siswa->nama,
        $siswa->jk,
        $siswa->telepon,
     ];   
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama',
            'Jenis Kelamin',
            'Telepon',
        ];
    }
    
        
}
