<?php

namespace App\Imports;

use App\Models\Jenis;
use App\Models\Dokumen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;

class DokumenImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    protected $jenisCache = [];
    protected $rows = 0;

    public function model(array $row)
    {
        ++$this->rows;

        $jenisId = $this->getJenisId($row['jenis']);

        return new Dokumen([
            'judul' => $row['judul'],
            'penulis' => $row['penulis'],
            'pembimbing' => $row['pembimbing'],
            'penguji' => $row['penguji'],
            'tahun' => $row['tahun'],
            'username' => auth()->user()->username,
            'jenis' => $jenisId,
            'abstrak' => $row['abstrak'],
            'keyword' => $row['keyword'],
        ]);
    }

    protected function getJenisId($jenisName)
    {
        if (!isset($this->jenisCache[$jenisName])) {
            $jenis = Jenis::where('nama_jenis', $jenisName)->first();

            if ($jenis) {
                $this->jenisCache[$jenisName] = $jenis->id;
            }
        }

        return $this->jenisCache[$jenisName];
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|min:15|max:250',
            'abstrak' => 'required|string',
            'penulis' => 'required|string|min:3',
            'pembimbing' => 'required|string|min:3',
            'penguji' => 'required|string|min:3',
            'jenis' => 'required',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'keyword' => 'required|string|min:3',
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
