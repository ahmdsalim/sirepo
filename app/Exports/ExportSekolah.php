<?php

namespace App\Exports;

use App\Models\Sekolah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportSekolah implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Sekolah::query();
    }

    public function map($sekolah): array
    {
     return [
        $sekolah->nama,
        $sekolah->npsn,
        $sekolah->jenjang,
        $sekolah->provinsi,
        $sekolah->kota,
        $sekolah->kecamatan,
        $sekolah->kelurahan,
        $sekolah->alamat,
        $sekolah->telepon,
        $sekolah->user->active ? 'Member' : 'Non-Member',

     ];   
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NPSN',
            'Jenjang',
            'Provinsi',
            'Kota',
            'Kecamatan',
            'Kelurahan',
            'Alamat',
            'No Telepon',
            'Status',
        ];
    }
}
