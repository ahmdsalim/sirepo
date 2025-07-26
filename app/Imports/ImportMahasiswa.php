<?php

namespace App\Imports;

use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Validation\Rule;
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

    private $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;

        if (isset($row['status'])) {
            $isActive = in_array($row['status'], ['Aktif', 'aktif']) ? 1 : 0;
        }

        $data = [
            'npm' => $row['npm'],
            'nama_mahasiswa' => $row['nama_mahasiswa'],
            'email' => $row['email'],
            'is_active' => $isActive,
        ];

        // Tambahkan 'kode_prodi' hanya jika peran pengguna adalah 'super'
        if (auth()->user()->role == 'super') {
            $data['kode_prodi'] = strtoupper($row['kode_prodi']);
        } else {
            $data['kode_prodi'] = auth()->user()->kode_prodi;
        }

        return new Mahasiswa($data);
    }

    public function rules(): array
    {
        return [
            'npm' => ['required', 'numeric', 'digits_between:1,12', Rule::unique('mahasiswas'), Rule::unique('users', 'username')],
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('mahasiswas'), Rule::unique('users')],
            'status' => 'required',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
