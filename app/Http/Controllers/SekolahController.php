<?php

namespace App\Http\Controllers;

use App\Exports\ExportSekolah;
use DB;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sekolah::query();
        $data['search'] = $request->query('search');
        $search = $data['search'];
        if($request->has('search') && !empty($search)){
            $query->where(function($query) use ($search) {
                $query->where('nama','like',"%{$search}%")
                      ->orWhere('npsn','like',"%{$search}%")
                      ->orWhere('provinsi','like',"%{$search}%");
            });
        }
        $data['sekolahs'] = $query->orderBy('created_at','desc')->paginate(25);
        return view('owner.sekolah.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.sekolah.form-sekolah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npsn' => 'required|numeric|unique:sekolahs,npsn',
            'nama' => 'required|max:120',
            'jenjang' => 'required|string',
            'alamat' => 'required|string|max:120',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'telepon' => 'required|numeric'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $saved = Sekolah::create([
                'npsn' => $data['npsn'],
                'nama' => $data['nama'],
                'jenjang' => $data['jenjang'],
                'alamat' => $data['alamat'],
                'provinsi' => $data['provinsi'],
                'kota' => $data['kota'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'telepon' => $data['telepon']
            ]);

            if(!$saved){
                return to_route('sekolah.index')->with('failed','Gagal');
            }
            return to_route('sekolah.index')->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah)
    {
        $data['sekolah'] = $sekolah;
        return view('owner.sekolah.show-sekolah', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        $data['sekolah'] = $sekolah;
        $provinsi = Http::get('https://ahmdsalim.github.io/api-wilayah-indonesia/api/provinces.json');
        $kota = Http::get("https://ahmdsalim.github.io/api-wilayah-indonesia/api/regencies/".explode('-',$sekolah->provinsi)[0].".json");
        $kecamatan = Http::get("https://ahmdsalim.github.io/api-wilayah-indonesia/api/districts/".explode('-',$sekolah->kota)[0].".json");
        $kelurahan = Http::get("https://ahmdsalim.github.io/api-wilayah-indonesia/api/villages/".explode('-',$sekolah->kecamatan)[0].".json");
        
        $data['provinsi'] = $provinsi->json();
        $data['kota'] = $kota->json();
        $data['kecamatan'] = $kecamatan->json();
        $data['kelurahan'] = $kelurahan->json();

        return view('owner.sekolah.form-sekolah', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $validator = Validator::make($request->all(), [
            'npsn' => 'required|numeric|unique:sekolahs,npsn,'.$sekolah->id,
            'nama' => 'required|max:120',
            'jenjang' => 'required|string',
            'alamat' => 'required|string|max:120',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'telepon' => 'required'
        ]);

        if($validator->passes()){
            $data = $validator->validated();
            $saved = $sekolah->update([
                'npsn' => $data['npsn'],
                'nama' => $data['nama'],
                'jenjang' => $data['jenjang'],
                'alamat' => $data['alamat'],
                'provinsi' => $data['provinsi'],
                'kota' => $data['kota'],
                'kecamatan' => $data['kecamatan'],
                'kelurahan' => $data['kelurahan'],
                'telepon' => $data['telepon']
            ]);

            if(!$saved){
                return to_route('sekolah.index')->with('failed','Gagal');
            }
            return to_route('sekolah.index')->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        $deleted = $sekolah->delete();
        if(!$deleted){
            return redirect()->back()->with('failed','Gagal');
        }
        return redirect()->back()->with('success','Berhasil');
    }

    public function getSekolah()
    {
        $data = Sekolah::doesntHave('user')->get();

        return response()->json($data);
    }

    public function errorImport(){

        return view('sekolah.error-import');
    }

    public function export(){
        return Excel::download(new ExportSekolah, 'daftar-sekolah-digilib.xlsx');
    }

    public function cetakPdf()
    {
        $data = Sekolah::all();
        view()->share('data', $data);
        $pdf = PDF::loadview('pdf.daftar_sekolah');
        return $pdf->download('daftar_sekolah.pdf');
    }
}
