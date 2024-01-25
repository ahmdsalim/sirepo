<?php

namespace App\Imports;

use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportSiswa implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = Auth::user();
        $npsn = $user->userable->npsn;

        return new Siswa([
            'nisn' => $row['nisn'],
            'nama' => $row['nama'],
            'jk' => $row['jk'],
            'telepon' => $row['telepon'],
            'npsn' => $npsn,
        ]);
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required|unique:siswas',
            'nama' => 'required',
            'jk' => 'required|in:L,P',
            'telepon' => 'required'
        ];
    }

    public function headingRow(): int
    {
        return 4;
    }
}
