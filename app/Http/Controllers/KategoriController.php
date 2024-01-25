<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kosong = '';
        $tittle = 'Kategori';
        $header = 'Data ' . $tittle;

        $data = Kategori::orderBy('kategori','asc')->paginate(25);
        if ($data->isEmpty()) {
            $kosong = 'Data tidak tersedia';
        }

        return view('kategori.kategori', compact('data', 'tittle', 'header', 'kosong'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tittle = 'Kategori';
        $header = 'Tambah ' . $tittle;
        return view('kategori.tambah-kategori', compact('tittle', 'header'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required|unique:kategoris',
            ],
            [
                'kategori.required' => 'kategori tidak boleh kosong',
                'kategori.unique' => 'kategori ' . $request->kategori . ' sudah digunakan',
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kategori = new Kategori();
        $kategori->kategori = $request->kategori;
        $kategori->slug = Str::slug(strtolower($request->kategori));
        $kategori->save();
        
        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data Telah Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tittle = 'Kategori';
        $header = 'Edit ' . $tittle;
        $data = Kategori::find($id);
        return view('kategori.edit-kategori', compact('data', 'tittle', 'header'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required|unique:kategoris',
            ],
            [
                'kategori.required' => 'kategori tidak boleh kosong',
                'kategori.unique' => 'kategori ' . $request->kategori . ' sudah digunakan',
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = Kategori::find($id);
        $data->update($request->all());
        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data Telah Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Kategori::find($id);
        $data->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data Telah Berhasil Di Hapus');
    }
}
