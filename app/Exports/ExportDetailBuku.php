<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportDetailBuku implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Buku::query()->with('rating')->withAvg('rating as avg_rating','score');
    }

    public function map($buku): array
    {
        return [
            $buku->judul,
            $buku->kategori->kategori,
            $buku->penulis,
            $buku->penerbit,
            $buku->no_isbn,
            $buku->jumlah_halaman,
            $buku->tahun_terbit,
            $buku->jumlah_dibaca,
            $buku->avg_rating,
            $buku->user->nama,
            $buku->status,
            $buku->deskripsi,
        ];
    }

    public function headings(): array
    {
        return [
            'Judul',
            'Kategori',
            'Penulis',
            'Penerbit',
            'No ISBN',
            'Jumlah Halaman',
            'Tahun Terbit',
            'Jumlah Di Baca',
            'Rating',
            'Pemilik',
            'Status',
            'Deskripsi',
        ];
    }
}
