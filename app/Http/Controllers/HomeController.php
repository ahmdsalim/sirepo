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
        }
        if (in_array(auth()->user()->role, ['super', 'admin'])) {
            $data['totalDocument'] = Dokumen::count();
            if (auth()->user()->role == 'admin') {
                $data['totalDocument'] = Dokumen::onlyLogged()->count();
            }
            //data chart
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
        }
        return view('home', $data);
    }
}
