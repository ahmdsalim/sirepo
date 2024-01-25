<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Sekolah;
use App\Exports\ExportSiswa;
use App\Imports\ImportSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PDF;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Siswa::query()->where('npsn',auth()->user()->userable->npsn);
        $data['search'] = $request->query('search');
        $search = $data['search'];
        if($request->has('search') && !empty($search)){
            $query->where(function($query) use ($search) {
                $query->where('nama','like',"%{$search}%")
                      ->orWhere('nisn','like',"%{$search}%");
            });
        }
        $data['siswas'] = $query->orderBy('nama','asc')->paginate(25);
        return view('sekolah.siswa.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sekolah.siswa.form-siswa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|numeric|unique:siswas,nisn',
            'nama' => 'required|max:120',
            'jk' => 'required|string|in:L,P',
            'telepon' => 'required|regex:/^08/'
        ],
        [
            'telepon.regex' => 'The :attribute must start with "08".'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $saved = Siswa::create([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jk' => $data['jk'],
                'telepon' => $data['telepon'],
                'npsn' => auth()->user()->userable->npsn
            ]);

            if(!$saved){
                return to_route('sekolah.siswa.index')->with('failed','Gagal');
            }
            return to_route('sekolah.siswa.index')->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($nisn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nisn)
    {
        $data['siswa'] = Siswa::where('nisn',$nisn)->first() ?? abort(404);
        return view('sekolah.siswa.form-siswa',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nisn)
    {
        $siswa = Siswa::where('nisn',$nisn)->first() ?? abort(404);
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|numeric|unique:siswas,nisn,'.$siswa->id,
            'nama' => 'required|max:120',
            'jk' => 'required|string|in:L,P',
            'telepon' => 'required|regex:/^08/'
        ],
        [
            'telepon.regex' => 'The :attribute must start with "08".'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $saved = $siswa->update([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jk' => $data['jk'],
                'telepon' => $data['telepon']
            ]);

            if(!$saved){
                return to_route('sekolah.siswa.index')->with('failed','Gagal');
            }
            return to_route('sekolah.siswa.index')->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nisn)
    {
        $siswa = Siswa::where('nisn',$nisn)->delete() ?? abort(404);
        if($siswa){
            return redirect()->back()->with('success','Berhasil');
        }
        return redirect()->back()->with('failed','Gagal');
    }

    public function getSiswa()
    {
        $data = Siswa::doesntHave('user')->get();

        return response()->json($data);
    }

    public function getSiswaBySekolah($npsn)
    {
        $data['sekolah'] = Sekolah::where('npsn',$npsn)->first();
        $query = Siswa::query()->where('npsn',$npsn);
        $data['siswas'] = $query->paginate(25);
        $data['search'] = '';
        return view('owner.siswa.siswa',$data);
    }

    public function editSiswa(Siswa $siswa)
    {
        $data['siswa'] = $siswa;

        return view('owner.siswa.edit-siswa',$data);
    }

    public function updateSiswa(Request $request, Siswa $siswa)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|numeric|unique:siswas,nisn,'.$siswa->id,
            'nama' => 'required|max:120',
            'jk' => 'required|string|in:L,P',
            'telepon' => 'required'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $saved = $siswa->update([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jk' => $data['jk'],
                'telepon' => $data['telepon']
            ]);

            if(!$saved){
                return to_route('owner.siswa.index',$siswa->npsn)->with('failed','Gagal');
            }
            return to_route('owner.siswa.index',$siswa->npsn)->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function destroySiswa(Siswa $siswa)
    {
        $deleted = $siswa->delete();
        if(!$deleted){
            return redirect()->back()->with('failed','Gagal');
        }
        return redirect()->back()->with('success','Berhasil');
    }


     public function import(Request $request){
        $file = $request->file('file')->store('public/files/excel/siswa/');

        $import = new ImportSiswa;
        $import->import($file);

        if($import->failures()->isNotEmpty()){
            return redirect()->route('siswa.error-import')->withFailures($import->failures());
        }

        return redirect()->back()->with('success','Import Data Siswa Berhasil');
    }

    public function export(){
        return Excel::download(new ExportSiswa, 'daftar-siswa.xlsx');
    }

    public function errorImport(){

        return view('sekolah.error-import');
    }

    public function cetakPdf(Request $request)
    {
    $user = auth()->user();

        if ($user->role == 'sekolah') {
            $npsn = $user->userable->npsn;
        }else{
            $npsn = $request->query('npsn');
        }
        $data = Siswa::where('npsn', $npsn)->get();

        view()->share('data', $data);

        $pdf = PDF::loadview('pdf.daftar_siswa');
        return $pdf->download('daftar_siswa.pdf');
    }
}
