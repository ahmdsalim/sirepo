<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis = Jenis::withCount('dokumens')->get();
        return view('landing.landing', compact('jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function profile()
    {
        $user = Auth::user();
        return view('landing.profile', compact('user'));
    }

    public function setting()
    {
        $user = Auth::user();
        return view('landing.setting.profile', compact('user'));
    }

    public function keamanan()
    {
        $user = Auth::user();
        return view('landing.setting.keamanan', compact('user'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $request->session()->put('searchKeyword', $keyword);
        $jenis = Jenis::all();
        $filters = $request->input('filter');
        $years = $request->input('tahun');

        $tahun = Dokumen::distinct('tahun')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun'); 
        $dokumen = Dokumen::query()->with('jenis');

        if ($keyword) {
            $dokumen->where(function ($query) use ($keyword) {
                $query->where('judul', 'like', "%$keyword%")->orWhere('penulis', 'like', "%$keyword%");
            });
        }

        if ($filters) {
            $dokumen->where(function ($query) use ($filters) {
                $query->whereIn('jenis_id', $filters);
            });
        }

        if ($years) {
            $dokumen->where(function ($query) use ($years) {
                $query->whereIn('tahun', $years);
            });
        }
        $dokumen = $dokumen->orderBy('tahun')->paginate(25);

        // dd($years);

        return view('landing.result', compact('dokumen', 'keyword', 'jenis', 'filters', 'years','tahun'));
    }

    public function detail($id, $slug)
    {
        // Ambil dokumen berdasarkan judul
        $dokumen = Dokumen::findOrFail($id);

        $pebimbings = explode('/', $dokumen->pembimbing);

        $pembimbing1 = $pebimbings[0] ?? null;
        $pembimbing2 = $pebimbings[1] ?? null;

        // Kirim data ke view
        return view('landing.detail', compact('dokumen', 'pembimbing1', 'pembimbing2'));
    }
}
