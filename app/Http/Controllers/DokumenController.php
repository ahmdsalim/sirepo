<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Dokumen;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\HashIdService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['header'] = 'asasa';
        $data['jenis'] = Jenis::select('id', 'nama_jenis')->get();
        return view('dokumen.index', $data);
    }

    public function getDocuments(Request $request)
    {
        $documents = Dokumen::with('jenis');
        if(auth()->user()->role == 'admin'){
            $documents = Dokumen::with('jenis')->where('username', auth()->user()->username);
        }

        return DataTables::eloquent($documents)
            ->editColumn('penulis', function ($row) {
                return Str::limit($row->penulis, 50, '...');
            })
            ->addColumn('nama_jenis', function ($row) {
                return $row->jenis->nama_jenis;
            })
            ->addColumn('file', function ($row) {
                $actionBtn = '<a href="' . Storage::url('file-dokumen/' . $row->file) . '" class="d-flex gap-1" target="_blank"><i class="bi bi-file-earmark-pdf-fill"></i> ' . Str::limit($row->file, 10, '...') . '</a>';
                return $actionBtn;
            })
            ->addColumn('action', function ($row) {
                $actionBtn =
                    '<a class="btn btn-primary btn-sm" href="' .
                    route('dokumens.edit', ['id' => $row->hash_id]) .
                    '">Edit</a>
                <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="' .
                    $row->hash_id .
                    '" id="btnDelete">
                    Hapus
                </button>';
                return $actionBtn;
            })
            ->rawColumns(['file', 'action'])
            ->toJson();
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
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|min:15|max:250',
            'abstrak' => 'required|string|min:100',
            'keyword' => 'required|string|min:3',
            'penulis' => 'required|string|min:3',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
            'jenis' => 'required|string',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $validData = $validator->validated();
            $dokumen = new Dokumen();
            $dokumen->judul = $validData['judul'];
            $dokumen->abstrak = $validData['abstrak'];
            $dokumen->keyword = $validData['keyword'];
            $dokumen->penulis = $validData['penulis'];
            $dokumen->tahun = $validData['tahun'];
            $dokumen->jenis_id = (new HashIdService())->decode($validData['jenis']);
            $dokumen->username = auth()->user()->username;

            if ($request->hasFile('file')) {
                $destination = 'public/file-dokumen/';
                $file = $request->file('file');
                $file_name = 'sirepo' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs($destination, $file_name);
                $dokumen->file = $file_name;
            }

            $dokumen->save();

            return response()->json(['success' => 'Berhasil menambah data', 'data' => $dokumen], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage(), 500]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['dok'] = Dokumen::findOrFail($id);
        return view('dokumen.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $jenis = Jenis::select('id','nama_jenis')->get();
        return view('dokumen.form-dokumen', compact('dokumen','jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|min:15|max:250',
            'abstrak' => 'required|string|min:100',
            'keyword' => 'required|string|min:3',
            'penulis' => 'required|string|min:3',
            'tahun' => 'required|digits:4|integer|min:2000|max:'.(date('Y')),
            'jenis' => 'required|string',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $validData = $validator->validated();
            $dokumen = Dokumen::findOrFail($id);
            $dokumen->judul = $validData['judul'];
            $dokumen->abstrak = $validData['abstrak'];
            $dokumen->keyword = $validData['keyword'];
            $dokumen->penulis = $validData['penulis'];
            $dokumen->tahun = $validData['tahun'];
            $dokumen->jenis_id = (new HashIdService())->decode($validData['jenis']);
            $dokumen->username = auth()->user()->username;
            
            if($request->hasFile('file')){
                $destination = 'public/file-dokumen/';
                $file = $request->file('file');
                $file_name = 'sirepo'.time().'.'.$file->getClientOriginalExtension();
                Storage::delete($destination . $dokumen->file);
                $file->storeAs($destination, $file_name);
                $dokumen->file = $file_name;
            }
    
            $dokumen->save();
    
            return to_route('dokumens.index')->with('success','Berhasil mengubah data');
        } catch (\Exception $e) {
            return back()->with('failed', 'Error: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dokumen = Dokumen::findOrFail($id);
            $destination = 'public/file-dokumen/';
            Storage::delete($destination . $dokumen->file);
            $dokumen->delete();

            return response()->json(['success' => 'Berhasil menghapus data'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
