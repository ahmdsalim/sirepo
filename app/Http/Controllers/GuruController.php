<?php

namespace App\Http\Controllers;

use App\Exports\ExportGuru;
use App\Models\Guru;
use App\Models\Sekolah;
use App\Exports\ExportSiswa;
use App\Imports\ImportGuru;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PDF; 

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Guru::query()->where('npsn',auth()->user()->userable->npsn);
        $data['search'] = $request->query('search');
        $search = $data['search'];
        if($request->has('search') && !empty($search)){
            $query->where(function($query) use ($search) {
                $query->where('nama','like',"%{$search}%")
                      ->orWhere('nip','like',"%{$search}%");
            });
        }
        $data['gurus'] = $query->orderBy('nama','asc')->paginate(50);
        return view('sekolah.guru.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sekolah.guru.form-guru');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|numeric|unique:gurus,nip',
            'nama' => 'required|max:120',
            'jk' => 'required|string|in:L,P',
            'telepon' => 'required|regex:/^08/'
        ],
        [
            'telepon.regex' => 'The :attribute must start with "08".'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $saved = Guru::create([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'jk' => $data['jk'],
                'telepon' => $data['telepon'],
                'npsn' => auth()->user()->userable->npsn
            ]);

            if(!$saved){
                return to_route('sekolah.guru.index')->with('failed','Gagal');
            }
            return to_route('sekolah.guru.index')->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nip)
    {
        $data['guru'] = Guru::where('nip',$nip)->first() ?? abort(404);
        return view('sekolah.guru.form-guru',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nip)
    {
        $guru = Guru::where('nip',$nip)->first() ?? abort(404);
        $validator = Validator::make($request->all(), [
            'nip' => 'required|numeric|unique:gurus,nip,'.$guru->id,
            'nama' => 'required|max:120',
            'jk' => 'required|string|in:L,P',
            'telepon' => 'required|regex:/^08/'
        ],
        [
            'telepon.regex' => 'The :attribute must start with "08".'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $saved = $guru->update([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'jk' => $data['jk'],
                'telepon' => $data['telepon']
            ]);

            if(!$saved){
                return to_route('sekolah.guru.index')->with('failed','Gagal');
            }
            return to_route('sekolah.guru.index')->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($nip)
    {
        $guru = Guru::where('nip',$nip)->delete() ?? abort(404);
        if($guru){
            return redirect()->back()->with('success','Berhasil');
        }
        return redirect()->back()->with('failed','Gagal');
    }

    public function getGuru()
    {
        $data = Guru::doesntHave('user')->get();

        return response()->json($data);
    }

    public function getGuruBySekolah($npsn)
    {
        $data['sekolah'] = Sekolah::where('npsn',$npsn)->first();
        $query = Guru::query()->where('npsn',$npsn);
        $data['gurus'] = $query->paginate(25);
        $data['search'] = '';
        return view('owner.guru.guru',$data);
    }

    public function editGuru(Guru $guru)
    {
        $data['guru'] = $guru;

        return view('owner.guru.edit-guru',$data);
    }

    public function updateGuru(Request $request, Guru $guru)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|numeric|unique:gurus,nip,'.$guru->id,
            'nama' => 'required|max:120',
            'jk' => 'required|string|in:L,P',
            'telepon' => 'required'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $saved = $guru->update([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'jk' => $data['jk'],
                'telepon' => $data['telepon']
            ]);

            if(!$saved){
                return to_route('owner.guru.index',$guru->npsn)->with('failed','Gagal');
            }
            return to_route('owner.guru.index',$guru->npsn)->with('success','Berhasil'); 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function destroyGuru(Guru $guru)
    {
        $deleted = $guru->delete();
        if(!$deleted){
            return redirect()->back()->with('failed','Gagal');
        }
        return redirect()->back()->with('success','Berhasil');
    }

    public function import(Request $request){
        $file = $request->file('file')->store('public/files/excel/guru/');

        $import = new ImportGuru;
        $import->import($file);

        if($import->failures()->isNotEmpty()){
            return redirect()->route('guru.error-import')->withFailures($import->failures());
        }

        return redirect()->back()->with('success','Import Data Guru Berhasil');
    }

    public function export(){
        return Excel::download(new ExportGuru, 'daftar-guru-digilib.xlsx');
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
        $data = Guru::where('npsn', $npsn)->get();

        view()->share('data', $data);

        $pdf = PDF::loadview('pdf.daftar_guru');
        return $pdf->download('daftar_guru.pdf');
    }
}
