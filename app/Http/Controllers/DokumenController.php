<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['header'] = 'asasa';
        return view('dokumen.index',$data);
    }

    public function getDocByUName()
    {
        $user = Auth::user()->username;
        $dokByUName = Dokumen::select('*')->with('jenis')->where('username', $user)->get();

        $formattedData = $dokByUName->map(function ($item) {
            return [
                // 'id' => $item->id,
                'judul' => $item->judul,
                'penulis' => $item->penulis,
                'tahun' => $item->tahun,
                'username' => $item->username,
                'jenis_id' => $item->jenis_id ,
                'file' => $item->file,
                'abstrak' => $item->abstrak,
                'keyword' => $item->keyword,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json(['status' => 200, 'message' => 'getDocByUName', 'data' => $formattedData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokumen.tambah-dokumen');
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
        return view('dokumen.edit-dokumen');
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
}
