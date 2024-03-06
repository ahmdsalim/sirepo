<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException; // Import class exception yang benar

class ImportMahasiswa implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        if (isset($row['status'])) {
            $isActive = $row['status'] != 'Aktif' ? 0 : 1;
        }

        $data = [
            'npm' => $row['npm'],
            'nama_mahasiswa' => $row['nama_mahasiswa'],
            'email' => $row['email'],
            'is_active' => $isActive,
        ];

        // Tambahkan 'kode_prodi' hanya jika peran pengguna adalah 'super'
        if (auth()->user()->role == 'super') {
            $data['kode_prodi'] = $row['kode_prodi'];
        }else{
            $data['kode_prodi'] = auth()->user()->kode_prodi;
        }

        return new Mahasiswa($data);
    }

    public function rules(): array
    {
        return [
            'npm' => 'required|unique:mahasiswas,npm',
            'nama_mahasiswa' => 'required',
            'email' => 'required|unique:mahasiswas,email',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
