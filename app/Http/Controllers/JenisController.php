<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // Page Length
        $pageNumber = ( $request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // get data from jenis table
        $query = Jenis::select('*');

        // Search
        $search = $request->search;
        $query = $query->where('nama_jenis', 'like', "%".$search."%");

        $orderByName = 'nama_jenis';
        switch($orderColumnIndex){
            case '0':
                $orderByName = 'nama_jenis';
                break;
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $jenis = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $jenis], 200);
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
            return response()->json(['errors' => $validator->errors()]);
        }

        Jenis::create([
            'nama_jenis' => $request->nama_jenis
        ]);

        return response()->json(['success'=>'Berhasil menambahkan data']);
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
            return response()->json(['errors' => $e->getMessage()], 200);
        }
    }
}
