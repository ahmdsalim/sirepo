<?php

namespace App\Exports;

use App\Models\Baca;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportPembaca implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        $user = Auth::user();

        if($user->role == 'sekolah'){
        return User::query()->with('baca')->whereIn('role', ['siswa','guru'])
        ->whereHas('baca')->where('npsn', auth()->user()->userable->npsn);
        }else if($user->role == 'owner'){
         return User::query()->with('baca')->whereIn('role', ['siswa','guru'])
        ->whereHas('baca');
        }
    }

    public function map($pembaca): array
    {
     return [
       $pembaca->userable->nama,
       $pembaca->email,
       $pembaca->userable->sekolah->nama,

     ];   
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Asal Sekolah',
        ];
    }
}
