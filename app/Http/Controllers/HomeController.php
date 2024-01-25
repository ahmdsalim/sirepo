<?php

namespace App\Http\Controllers;

use App\Models\Baca;
use App\Models\Buku;
use App\Models\Guru;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Koleksi;
use App\Models\Siswa;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $req)
    {
        $bukuterbaru = buku::query();
        $input_kategori = $req->query('kategori');

        if (!is_null($input_kategori)) {
            $bukuterbaru->where('kategori_id', $input_kategori);
        }

        $bukuterbaru = $bukuterbaru
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        $bukuterpopuler = buku::query();
        if (!is_null($input_kategori)) {
            $bukuterpopuler->where('kategori_id', $input_kategori);
        }

        $bukuterpopuler = $bukuterpopuler
            ->where('status', 'publish')
            ->orderBy('jumlah_baca', 'desc')
            ->take(12)
            ->get();
        return view('landing', compact('bukuterbaru', 'bukuterpopuler'));
    }

    public function home()
    {
        $data['total_pembaca'] = User::whereIn('role', ['siswa', 'guru'])
            ->where('active',1)
            ->whereHas('baca')
            ->count();
        $data['total_pengguna'] = User::whereIn('role', ['siswa', 'guru'])->where('active',1)->count();
        
        $averageReadingTimePerDay = Baca::select(DB::raw('DATE(started_at) as reading_date'), DB::raw('SUM(TIMESTAMPDIFF(SECOND, started_at, end_at)) as total_duration'))
            ->groupBy('reading_date')
            ->get();
        // Menghitung rata-rata waktu baca per hari
        $totalDuration = 0;
        $totalDays = $averageReadingTimePerDay->count();

        foreach ($averageReadingTimePerDay as $readingDay) {
            $totalDuration += $readingDay->total_duration;
        }

        $data['avg_waktubaca_perhari'] = $totalDays > 0 ? $totalDuration / 60 / $totalDays : 0;

        $data['total_buku'] = Buku::where('status','publish')->count();
        $avgpagesread = Baca::select(DB::raw('DATE(started_at) as reading_date'), DB::raw('AVG((progress-prev_progress)) as avg_pages_read'))
                                      ->groupBy('reading_date')
                                      ->get();
        $totalPageRead = 0;
        $totalPageReadDays = $avgpagesread->count();

        foreach ($avgpagesread as $pagereadDay) {
            $totalPageRead += $pagereadDay->avg_pages_read;
        }

        $data['avg_haldibaca'] = $totalPageReadDays > 0 ? ($totalPageRead / $totalPageReadDays) : 0;
        $data['total_buku_dibaca'] = Buku::whereHas('baca')->count();

        $data['buku_terpopuler'] = Buku::where('status','publish')->orderByDesc('jumlah_baca')->take(10)->get();

        // $data['buku_rating_tertinggi'] = Buku::with('rating')
        //                                      ->withAvg('rating as average_rating', 'score')
        //                                      ->orderByDesc('average_rating')
        //                                      ->get()
        //                                      ->take(10);

        $data['top_users'] = User::withCount('baca as total_baca')
                                 ->whereIn('role',['siswa','guru'])
                                 ->whereHas('baca')
                                 ->where('active',1)
                                 ->orderByDesc('total_baca')
                                 ->limit(10)
                                 ->get();
        // dd($data['top_users']);
        return view('home', $data);
    }

    public function homesekolah()
    {
        $user = Auth::user();
        $npsn = $user->userable->npsn;
        $email = $user->email;

        $data['total_pengguna'] = User::whereHas('userable', function ($query) use ($npsn) {
            $query->where('npsn', $npsn);
        })
            ->where('role', ['siswa', 'guru'])
            ->count();

        $data['total_buku'] = Buku::whereHas('user', function ($query) use ($npsn) {
            $query->whereHas('userable', function ($query) use ($npsn) {
                $query->where('npsn', $npsn);
            });
        })
            ->where('status', 'publish')
            ->count();

        $data['total_buku_dibaca'] = Buku::whereHas('user', function ($query) use ($npsn) {
            $query->whereHas('userable', function ($query) use ($npsn) {
                $query->where('npsn', $npsn);
            });
        })
            ->whereHas('baca')
            ->count();

        $averageReadingTimePerDay = Baca::select(DB::raw('DATE(started_at) as reading_date'), DB::raw('SUM(TIMESTAMPDIFF(SECOND, started_at, end_at)) as total_duration'))
            ->whereHas('user', function ($query) use ($npsn) {
                $query->whereHas('userable', function ($query) use ($npsn) {
                    $query->where('npsn', $npsn);
                });
            })
            ->groupBy('reading_date')
            ->get();
        // Menghitung rata-rata waktu baca per hari
        $totalDuration = 0;
        $totalDays = $averageReadingTimePerDay->count();

        foreach ($averageReadingTimePerDay as $readingDay) {
            $totalDuration += $readingDay->total_duration;
        }

        $data['avg_waktubaca_perhari'] = $totalDays > 0 ? $totalDuration / 60 / $totalDays : 0;

        $avgpagesread = Baca::select(DB::raw('AVG((progress-prev_progress)) as avg_pages_read'))
            ->whereHas('user', function ($query) use ($npsn) {
                $query->whereHas('userable', function ($query) use ($npsn) {
                    $query->where('npsn', $npsn);
                });
            })
            ->get();
        $data['avg_haldibaca'] = $avgpagesread[0]->avg_pages_read;

        $data['total_pembaca'] = User::whereIn('role', ['siswa', 'guru'])
            ->whereHas('baca', function ($query) use ($npsn) {
                $query->whereHas('user', function ($query) use ($npsn) {
                    $query->whereHas('userable', function ($query) use ($npsn) {
                        $query->where('npsn', $npsn);
                    });
                });
            })
            ->count();

        $data['total_siswa'] = Siswa::where('npsn', $npsn)->count();
        $data['total_guru'] = Guru::where('npsn', $npsn)->count();

        $data['readers'] = User::whereIn('role', ['siswa','guru'])
                                 ->whereHas('userable', function($query) use ($npsn) {
                                    $query->where('npsn', $npsn);
                                 })
                                 ->whereHas('baca')
                                 ->get()
                                 ->sortByDesc(function ($value) {
                                    return $value->baca()->get()->unique('buku_id')->count();
                                 })
                                 ->take(10);

        $data['topBuku'] = Buku::whereHas('user', function ($query) {
            $query->whereHas('userable', function ($query) {
                $query->where('npsn', auth()->user()->userable->npsn);
            });
        })
            ->orderBy('jumlah_baca')
            ->limit(10)
            ->get();

        return view('sekolah.home', $data);
    }
}
