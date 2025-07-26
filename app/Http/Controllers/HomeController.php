<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jenis;
use App\Models\Dokumen;
use App\Models\Download;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];
        if (auth()->user()->role == 'super') {
            $data['totalUser'] = User::onlyuser()->count();
            $data['totalAdmin'] = User::onlyadmin()->count();
        }
        if (in_array(auth()->user()->role, ['super', 'admin'])) {
            $data['totalDocument'] = Dokumen::count();
            $data['totalUnduhan'] = Download::sum('total');
            $data['totalMahasiswa'] = Mahasiswa::count();
            if (auth()->user()->role == 'admin') {
                $data['totalDocument'] = Dokumen::onlySameProdi()->count();
                $data['totalUnduhan'] = Download::onlySameProdi()->sum('total');
                $data['totalMahasiswa'] = Mahasiswa::onlySameProdi()->count();
            }
            //Data chart total dokumen
            $tahun = date('Y');
            $bulan = date('m');
            for ($i = 1; $i <= $bulan; $i++) {
                if (auth()->user()->role == 'admin') {
                    $totalDoc = Dokumen::onlyLogged()->whereYear('created_at', $tahun)->whereMonth('created_at', $i)->count();
                } else {
                    $totalDoc = Dokumen::whereYear('created_at', $tahun)->whereMonth('created_at', $i)->count();
                }
                $dataBulan[] = formatMonthId($i);
                $dataTotalDoc[] = $totalDoc;
            }
            $data['dataBulan'] = $dataBulan;
            $data['dataTotalDoc'] = $dataTotalDoc;
            //Data chart jenis
            if (auth()->user()->role == 'admin') {
                $jenisDokumen = Jenis::withCount(['dokumens' => function ($query) {
                    $query->onlyLogged();
                }])->get();
            } else {
                $jenisDokumen = Jenis::withCount('dokumens')->get();
            }
            $data['dataJenis'] = collect($jenisDokumen)->map(function ($jenis) {
                return [$jenis->nama_jenis => $jenis->dokumens_count];
            })->toArray();
            //Data chart download
            $endDate = date('Y-m-d'); // Tanggal akhir rentang (format: tahun-bulan-tanggal)
            $startTimestamp = strtotime('-6 days', strtotime($endDate));
            $endTimestamp = strtotime($endDate);

            while ($startTimestamp <= $endTimestamp) {
                $currentDate = date('Y-m-d', $startTimestamp);

                if (auth()->user()->role == 'admin') {
                    $user = auth()->user();
                    $totalDownload = Download::whereHas('dokumen', function ($query) use ($user) {
                        $query->whereHas('user', function ($subquery) use ($user) {
                            $subquery->where('kode_prodi', $user->kode_prodi);
                        });
                    })->whereDate('created_at', $currentDate)->sum('total');
                } else {
                    $totalDownload = Download::whereDate('created_at', $currentDate)->sum('total');
                }
                if (empty($totalDownload)) $totalDownload = 0;
                $dataTanggal[] = date('Y-m-d', strtotime($currentDate));
                $dataTotalDownload[] = $totalDownload;

                $startTimestamp = strtotime('+1 day', $startTimestamp); // Pindah ke tanggal berikutnya
            }

            $data['dataTanggal'] = $dataTanggal;
            $data['dataTotalDownload'] = $dataTotalDownload;
        }
        return view('home', $data);
    }
}
