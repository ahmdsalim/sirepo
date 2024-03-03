<?php

namespace App\Imports;

use App\Models\Jenis;
use App\Models\Dokumen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DokumenImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $jenis = Jenis::where('nama_jenis', $row['jenis_id'])->first();

        return new Dokumen([
            'judul' => $row['judul'],
            'penulis' => $row['penulis'],
            'pembimbing' => $row['pembimbing'],
            'penguji' => $row['penguji'],
            'tahun' => $row['tahun'],
            'username' => auth()->user()->username,
            'jenis_id' => $row['jenis_id'] ?? null,
            'abstrak' => $row['abstrak'],
            'keyword' => $row['keyword'],
        ]);
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|min:15|max:250',
            'abstrak' => 'required|string|min:100',
            'keyword' => 'required|string|min:3',
            'penulis' => 'required|string|min:3',
            'pembimbing' => 'required|string|min:3',
            'penguji' => 'required|string|min:3',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'jenis_id' => 'required',
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}
