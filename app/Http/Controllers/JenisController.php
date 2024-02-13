<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('super.jenis.index');
    }

    public function getJenis(Request $request) {
        $jenis = Jenis::latest()->get();
            return DataTables::of($jenis)
                ->addColumn('action', function($row) {
                    $actionBtn = '<a class="btn btn-primary btn-sm" href="'.route("jenis.edit",["id"=>$row->hash_id]).'">Edit</a>
                    <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="'.$row->hash_id.'" id="btnDelete">
                        Hapus
                    </button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
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
        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'required|min:1|max:150'
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()],422);
        }

        Jenis::create([
            'nama_jenis' => $request->nama_jenis
        ]);

        return response()->json(['success'=>'Berhasil menambahkan data'],200);
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
        $jenis = Jenis::findOrFail($id);

        return view('super.jenis.form-jenis', compact('jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'required|min:1|max:150'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validData = $validator->validated();

        $jenis = Jenis::findOrFail($id);
        $jenis->update([
            'nama_jenis' => $validData['nama_jenis']
        ]);

        return to_route('jenis.index')->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $jenis = Jenis::findOrFail($id);
            $jenis->delete();
    
            return response()->json(['success' => 'Berhasil menghapus data'], 200);
        }catch(\Exception $e){
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
