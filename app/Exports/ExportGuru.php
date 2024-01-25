<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportGuru implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Guru::query()->where('npsn',auth()->user()->userable->npsn);
    }

    public function map($siswa): array
    {
     return [
        $siswa->nip,
        $siswa->nama,
        $siswa->jk,
        $siswa->telepon,
     ];   
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama',
            'Jenis Kelamin',
            'Telepon',
        ];
    }
}
