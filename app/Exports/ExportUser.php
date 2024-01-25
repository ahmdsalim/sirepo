<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportUser implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $user = Auth::user();

        if($user->role == 'sekolah'){
        return User::whereHas('userable', function ($query) {
            $query->where('npsn', auth()->user()->userable->npsn);
        })
            ->whereIn('role',['siswa','guru']);
        }else if($user->role == 'owner'){
            return User::query();
        }
    }

    public function map($user): array
    {
        return [
            $user->nama,
            $user->email,
            $user->active ? 'Aktif' : 'Non-Aktif',
            $user->role,
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Username', 'Status', 'Akses'];
    }
}
