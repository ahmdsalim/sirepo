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
        return view('dokumen.index', $data);
    }

    public function getDocByUName(Request $request)
    {
        $pageNumber = $request->start / $request->length + 1;
        $pageLength = $request->length;
        $skip = ($pageNumber - 1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        $user = Auth::user()->username;
        $query = Dokumen::select('dokumens.*', 'jenis.nama_jenis')
                ->leftJoin('jenis', 'dokumens.jenis_id', '=', 'jenis.id')
                ->where('dokumens.username', $user);


        $search = $request->search;
        $query = $query->where(function ($query) use ($search) {
            $query->orWhere('judul', 'like', '%' . $search . '%');
            $query->orWhere('penulis', 'like', '%' . $search . '%');
            $query->orWhere('tahun', 'like', '%' . $search . '%');
            $query->orWhere('keyword', 'like', '%' . $search . '%');
        });

        $orderByName = 'judul';
        switch ($orderColumnIndex) {
            case '0':
                $orderByName = 'judul';
                break;
            case '1':
                $orderByName = 'penulis';
                break;
            case '2':
                $orderByName = 'tahun';
                break;
            case '3':
                $orderByName = 'jenis_id';
                break;
        }

        $query = $query->orderBy($orderByName, $orderBy);
        $recordsTotal = $query->count();
        $dok = $query->skip($skip)->take($pageLength)->get();
        $recordsFiltered = $dok->count();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $dok,
            'status' => 200,
            'message' => 'getDocByUName',
        ]);
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
    public function show(Dokumen $dokumen)
    {
        return view('dokumen.detail',compact($dokumen));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumen $dokumen)
    {
        return view('dokumen.edit-dokumen', compact($dokumen));
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
