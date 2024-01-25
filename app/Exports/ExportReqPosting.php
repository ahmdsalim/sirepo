<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportReqPosting implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Buku::query()->where('status', 'pending');
    }

    public function map($reqPosting): array
    {
        return [
        $reqPosting->judul, 
        $reqPosting->kategori->kategori, 
        $reqPosting->penulis, 
        $reqPosting->penerbit, 
        $reqPosting->no_isbn, 
        $reqPosting->jumlah_halaman, 
        $reqPosting->tahun_terbit, 
        $reqPosting->jumlah_baca, 
        $reqPosting->avg_rating, 
        $reqPosting->user->nama, 
        $reqPosting->status, 
        $reqPosting->deskripsi];
    }

    public function headings(): array
    {
        return ['Judul', 
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
        'Deskripsi'];
    }

}
