<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportMahasiswa implements ToModel,WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mahasiswa([
            'npm' => $row['npm'],
            'nama_mahasiswa' => $row['nama_mahasiswa'],
            'email' => $row['email'],
            'is_active' => 0
        ]);
    }

    public function rules(): array
    {
        return [
            'npm' => 'required|unique:mahasiswas',
            'nama_mahasiswa' => 'required',
            'email' => 'required',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
