<?php

namespace App\Http\Controllers;

use App\Exports\ExportPembaca;
use App\Models\Baca;
use Illuminate\Http\Request;
use App\Models\Buku;
use Auth;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class BacaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexpembaca(Request $request)
    {
        $user = auth()->user();
        $selesaibaca = Baca::join('bukus','bacas.buku_id','=','bukus.id')
                     ->where('bacas.email', $user->email)
                     ->where('bacas.progress', DB::raw('bukus.jumlah_halaman'))
                     ->orderBy('bacas.started_at', 'desc')
                     ->take(12)
                     ->get()->unique('buku_id');    
        $lanjutbaca = Baca::join('bukus', 'bacas.buku_id', '=', 'bukus.id')
                     ->where('bacas.email', $user->email)
                     ->where('bacas.progress','<', DB::raw('bukus.jumlah_halaman'))
                     ->orderBy('bacas.started_at', 'desc')
                     ->take(12)
                     ->get()    
                     ->unique('buku_id');
        return view('terakhirdibaca', compact('selesaibaca','lanjutbaca'));
    }

    public function index(Request $request)
    {
        
        $query = User::query();
        $data['search'] = $request->query('search');
        $search = $data['search'];
        $user = Auth::user();

        if($request->has('search') && !empty($search)){
            $query->where(function($query) use ($search) {
                $query->where('nama','like',"%{$search}%")
                      ->orWhere('email','like',"%{$search}%");
            });
        }

        if(Auth::user()->role == 'sekolah'){
            $query->whereHasMorph(
                'userable',
                [Siswa::class, Guru::class],
                function ($query) use ($user) {
                    $query->where('npsn', $user->userable->npsn);
                }
            );
        }

        $data['readers'] = $query->whereIn('role', ['siswa','guru'])
                                 ->whereHas('baca')
                                 ->paginate(25);
        return view('pembaca.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detail($id)
    {
        $id = \Crypt::decryptString($id);
        $data['reader'] = User::findOrFail($id);

        return view('pembaca.detail',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request)
    {
        $user = auth()->user();
        $buku_id = \Crypt::decryptString($request->buku_id);
        $buku = Buku::findOrFail($buku_id);

        $baca = Baca::updateOrCreate(
            [
                'sesi' => $request->sesi
            ],
            [
                'email' => $user->email,
                'buku_id' => $buku_id,
                'prev_progress' => $request->prev_progress,
                'progress' => $request->progress
            ]
        );

        if($baca){
            return response()->json(['message' => 'Successfully saved'], 200);
        }
        return response()->json(['message' => 'Server Error'], 500);

    }

    public function read($id, $slug)
    {
        $user = auth()->user();
        $data['buku'] = Buku::where([['id',$id],['slug',$slug],['status','publish']])->first() ?? abort(404);
        $data['buku']->update(['jumlah_baca' => $data['buku']->jumlah_baca+1]);
        $data['sesi'] = \Str::random(16);
        $data['latestPage'] = 1;
        $data['prevPage'] = 0;
        $data['newReader'] = true;
        $baca = Baca::where('email',$user->email)->where('buku_id',$id)->orderBy('started_at','desc')->first();
        if($baca) {
            $data['prevPage'] = $baca->progress;
            $data['latestPage'] = $baca->progress;
            $data['newReader'] = false;
        }
        return view('read', $data);
    }

    public function readinglist(Request $request)
    {
        $user = auth()->user();
        $sort = $request->query('orderby');
        $data['orderby'] = $sort;
        $data['readinglist'] = Buku::where('status','publish')->whereHas('baca', function($query) use ($user, $sort) {
            if(!empty($sort)){
                if($sort == 'ongoing'){
                    $query->where('bacas.progress', '<', DB::raw('bukus.jumlah_halaman'));
                }elseif ($sort == 'completed') {
                    $query->where('bacas.progress', DB::raw('bukus.jumlah_halaman'));
                }
            }
            $query->where('bacas.email',$user->email)
                  ->orderBy('bacas.end_at','desc');
        })
        ->paginate(12);

        return view('readinglist', $data);
    }

    public function export(){
        return Excel::download(new ExportPembaca, 'daftar-pembaca-digilib.xlsx');
    }

    public function cetakPdf(Request $request)
    {
        $query = User::query();
        $user = Auth::user();

        if(Auth::user()->role == 'sekolah'){
            $query->whereHasMorph(
                'userable',
                [Siswa::class, Guru::class],
                function ($query) use ($user) {
                    $query->where('npsn', $user->userable->npsn);
                }
            );
        }

        $data = $query->whereHas('baca')
                      ->get()
                      ->sortByDesc(function ($value) {
                            return $value->baca()->get()->unique('buku_id')->count();
                        });
     
        view()->share('data', $data);
        $pdf = PDF::loadview('pdf.daftar_pembaca');
        return $pdf->download('daftar_pembaca.pdf');
    }
}
