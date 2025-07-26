<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('super.prodi.index');
    }

    public function getProdi()
    {
        $prodi = Prodi::latest()->get();
        return DataTables::of($prodi)
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="btn btn-primary btn-sm" href="' . route("prodi.edit", ["prodi" => $row->kode_prodi]) . '">Edit</a>
                    <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="' . $row->kode_prodi . '" id="btnDelete">
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
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'kode_prodi' => 'required|max:50|regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]+$/|unique:prodis,kode_prodi',
                    'nama_prodi' => 'required|string|max:100'
                ],
                [
                    'kode_prodi.regex' => 'Kode prodi harus mengandung kombinasi huruf dan angka'
                ]
            );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $validData = $validator->validated();
            DB::beginTransaction();
            Prodi::create([
                'kode_prodi' => $validData['kode_prodi'],
                'nama_prodi' => $validData['nama_prodi']
            ]);
            DB::commit();
            return response()->json(['success' => 'Berhasil menambah data prodi']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
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
    public function edit(Prodi $prodi)
    {
        return view('super.prodi.form-prodi', compact('prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'kode_prodi' => [
                        'required', 'max:50', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9]+$/',
                        Rule::unique('users')->ignore($prodi->kode_prodi, 'kode_prodi')
                    ],
                    'nama_prodi' => 'required|string|max:100'
                ],
                [
                    'kode_prodi.regex' => 'Kode prodi harus mengandung kombinasi huruf dan angka'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validData = $validator->validated();
            DB::beginTransaction();
            $prodi->update([
                'kode_prodi' => $validData['kode_prodi'],
                'nama_prodi' => $validData['nama_prodi']
            ]);
            DB::commit();
            return to_route('prodi.index')->with('success', 'Berhasil mengupdate data prodi');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        try {
            $prodi->delete();
            return response()->json(['success' => 'Berhasil menghapus data prodi']);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
