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
    protected $prodiCache = [];

    public function model(array $row)
    {
        $prodiId = $this->getProdiId($row['prodi_id']);

        if (isset($row['status'])) {
            $isActive = $row['status'] != 'Aktif' ? 0 : 1;
        }

        return new Mahasiswa([
            'npm' => $row['npm'],
            'nama_mahasiswa' => $row['nama_mahasiswa'],
            'email' => $row['email'],
            'prodi_id' => $prodiId,
            'is_active' => $isActive,
        ]);
    }

    protected function getProdiId($prodiName)
    {
        if (!isset($this->prodiCache[$prodiName])) {
            $prodi = Prodi::where('nama_prodi', $prodiName)->first();

            if ($prodi) {
                $this->prodiCache[$prodiName] = $prodi->id;
            } else {
                throw new \Exception("Prodi dengan nama '$prodiName' tidak ditemukan.");
            }
        }

        return $this->prodiCache[$prodiName];
    }

    public function rules(): array
    {
        return [
            'npm' => 'required|unique:mahasiswas,npm',
            'nama_mahasiswa' => 'required',
            'prodi_id' => 'required',
            'email' => 'required|unique:mahasiswas,email',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
