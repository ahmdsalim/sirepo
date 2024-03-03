<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\ImportMahasiswa;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.mahasiswas.index');
    }

    public function getMahasiswa()
    {
        $mhs = Mahasiswa::latest()->get();
        return DataTables::of($mhs)
            ->addColumn('action', function ($row) {
                $actionBtn =
                    '<a class="btn btn-primary btn-sm" href="' .
                    route('mahasiswas.edit', ['mahasiswa' => $row->npm]) .
                    '">Edit</a>
                <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="' .
                    $row->npm .
                    '" id="btnDelete">
                    Hapus
                </button>';
                return $actionBtn;
            })

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
            'email' => 'required|email|unique:mahasiswas,email',
            'nama_mahasiswa' => 'required|string|min:1|max:255',
            'npm' => 'required|string|min:1|max:12|unique:mahasiswas,npm',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validData = $validator->validated();
        $user = Mahasiswa::create([
            'npm' => $validData['npm'],
            'nama_mahasiswa' => $validData['nama_mahasiswa'],
            'email' => $validData['email'],
            'is_active' => false,
        ]);

        return response()->json(['success' => 'Berhasil menambahkan pengguna', 'data' => $user], 200);
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
    public function edit(string $npm)
    {
        $mhs = Mahasiswa::findOrFail($npm);

        return view('admin.mahasiswas.form-mahasiswa', compact('mhs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $npm)
    {
        $mhs = Mahasiswa::findOrFail($npm);
        $validator = Validator::make($request->all(), [
            'nama_mahasiswa' => 'required|string|min:1|max:255',
            'email' => ['required', 'email', Rule::unique('mahasiswas')->ignore($mhs->npm, 'npm')],
            'npm' => ['required', 'string', 'min:1', 'max:12', Rule::unique('mahasiswas')->ignore($mhs->npm, 'npm')],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validData = $validator->validated();
        $data = [
            'nama_mahasiswa' => $validData['nama_mahasiswa'],
            'email' => $validData['email'],
            'npm' => $validData['npm'],
        ];

        $mhs->update($data);

        return to_route('mahasiswas.index')->with('success', 'Berhasil mengupdate data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $npm)
    {
        try {
            $mhs = Mahasiswa::findOrFail($npm);
            $mhs->delete();

            return response()->json(['success' => 'Berhasil menghapus data'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file')->storeAs('upload/excel/mahasiswa', 'mahasiswa.xlsx');

        // Pass the file path to the import method
        $import = new ImportMahasiswa();
        $import->import($file, null, \Maatwebsite\Excel\Excel::XLSX);
        // dd($import);

        if ($import->failures()->isNotEmpty()) {
            return redirect()->route('mahasiswas.errorImport')->withFailures($import->failures());
        }

        return redirect()->back()->with('success', 'Import Data Mahasiswa Berhasil');
    }

    public function errorImport()
    {
        return view('admin.error-import');
    }
}
