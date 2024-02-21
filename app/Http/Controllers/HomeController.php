<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jenis;
use App\Models\Dokumen;
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
            $data['totalApproved'] = User::onlyuser()->approved()->count();
            $data['totalModeration'] = User::onlyuser()->toapprove()->count();
            $tahun = date('Y');
            $bulan = date('m');
            for ($i = 1; $i <= $bulan; $i++) {
                $totalDoc = Dokumen::whereYear('created_at', $tahun)->whereMonth('created_at', $i)->count();
                $dataBulan[] = formatMonthId($i);
                $dataTotalDoc[] = $totalDoc;
            }
            $data['dataBulan'] = $dataBulan;
            $data['dataTotalDoc'] = $dataTotalDoc;
            $jenisDokumen = Jenis::withCount('dokumens')->get();
            $data['dataJenis'] = collect($jenisDokumen)->map(function ($jenis) {
                return [$jenis->nama_jenis => $jenis->dokumens_count];
            })->toArray();
        }
        if (in_array(auth()->user()->role, ['super', 'admin'])) {
            $data['totalDocument'] = Dokumen::count();
            if (auth()->user()->role == 'admin') {
                $data['totalDocument'] = Dokumen::onlyLogged()->count();
            }
        }
        return view('home', $data);
    }
}
