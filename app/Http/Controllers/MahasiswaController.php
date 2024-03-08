<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\ImportMahasiswa;
use Illuminate\Support\Facades\DB;
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
        $prodi = Prodi::all();
        return view('admin.mahasiswas.index', compact('prodi'));
    }

    public function getMahasiswa()
    {
        $user = auth()->user();
        $mhs = Mahasiswa::with('prodi');

        if ($user->role == 'admin') {
            $mhs = Mahasiswa::with('prodi')->where('kode_prodi', $user->kode_prodi);
        }
        // if (auth()->user()->role == 'admin') {
        //     $mhs = Mahasiswa::with('prodi')
        //         ->where('kode_prodi', auth()->user()->kode_prodi);
        // }
        return DataTables::of($mhs)
            ->addColumn('action', function ($row) {
                $color = $row->is_active ? 'secondary' : 'success';
                $text = $row->is_active ? 'Nonaktifkan' : 'Aktifkan';
                $actionBtn =
                    '<button type="button" class="btn btn-' . $color . ' text-white btn-sm activate-button" data-id="' . encryptString($row->npm) . '" id="btnActivate">
                    ' . $text . '
                </button>
                    <a class="btn btn-primary btn-sm" href="' .
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
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:mahasiswas,email',
                'nama_mahasiswa' => 'required|string|min:1|max:255',
                'npm' => 'required|string|min:1|max:12|unique:mahasiswas,npm',
                'is_active' => 'required',
            ]);

            if (auth()->user()->role == 'super') {
                $validator->sometimes('kode_prodi', 'required', function ($input) {
                    return true; // Selalu validasi 'kode_prodi' jika peran pengguna adalah 'super'
                });
            }

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $validData = $validator->validated();

            $user = new Mahasiswa();
            $user->npm = $validData['npm'];
            $user->nama_mahasiswa = $validData['nama_mahasiswa'];
            $user->email = $validData['email'];
            if (auth()->user()->role == 'super') {
                $user->kode_prodi = $validData['kode_prodi'];
            } else {
                $user->kode_prodi = auth()->user()->kode_prodi;
            }
            $user->is_active = $validData['is_active'];
            DB::beginTransaction();
            $user->save();
            DB::commit();
            return response()->json(['success' => 'Berhasil menambahkan data mahasiswa', 'data' => $user], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => 'Gagal menambahkan data mahasiswa : ' . $e->getMessage()], 500);
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
    public function edit(string $npm)
    {
        $mhs = Mahasiswa::findOrFail($npm);
        $prodi = Prodi::all();

        return view('admin.mahasiswas.form-mahasiswa', compact('mhs', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $npm)
    {
        try {
            $mhs = Mahasiswa::findOrFail($npm);
            $validator = Validator::make($request->all(), [
                'nama_mahasiswa' => 'required|string|min:1|max:255',
                'email' => ['required', 'email', Rule::unique('mahasiswas')->ignore($mhs->npm, 'npm')],
                'npm' => ['required', 'string', 'min:1', 'max:12', Rule::unique('mahasiswas')->ignore($mhs->npm, 'npm')],
                'is_active' => 'required',
            ]);

            if (auth()->user()->role == 'super') {
                $validator->sometimes('kode_prodi', 'required', function ($input) {
                    return true; // Selalu validasi 'kode_prodi' jika peran pengguna adalah 'super'
                });
            }

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validData = $validator->validated();
            $data = [
                'nama_mahasiswa' => $validData['nama_mahasiswa'],
                'email' => $validData['email'],
                'npm' => $validData['npm'],
                $mhs->kode_prodi = auth()->user()->role == 'super' ? $validData['kode_prodi'] : auth()->user()->kode_prodi,
                'is_active' => $validData['is_active'],
            ];
            DB::beginTransaction();
            if ($validData['is_active'] != $mhs->is_active && !empty($mhs->user)) {
                $mhs->user()->update([
                    'is_active' => $validData['is_active']
                ]);
            }

            $mhs->update($data);
            DB::commit();
            return to_route('mahasiswas.index')->with('success', 'Berhasil mengupdate data');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('failed', 'Gagal mengupdate data : ' . $e->getMessage());
        }
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

        $file = $request->file('file');
        try {
            DB::beginTransaction();
            // Pass the file path to the import method
            $import = new ImportMahasiswa();
            $import->import($file, null, \Maatwebsite\Excel\Excel::XLSX);
            // dd($import);

            if ($import->failures()->isNotEmpty()) {
                DB::rollback();
                return redirect()->route('mahasiswas.errorImport')->withFailures($import->failures());
            }

            if ($import->getRowCount() == 0) {
                DB::rollback();
                return back()->with('failed', 'Import Gagal: Data tidak ditemukan');
            }

            DB::commit();
            return to_route('mahasiswas.index')->with('success', 'Import Data Mahasiswa Berhasil');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                $message = ': Kode prodi yang Anda import tidak sesuai';
            }
            return back()->with('failed', 'Import Gagal ' . $message);
        }
    }

    public function errorImport()
    {
        return view('admin.mahasiswas.error-import');
    }

    public function getUnsyncMhs()
    {
        try {
            $mahasiswa = Mahasiswa::select('npm', 'nama_mahasiswa')->doesntHave('user')->get();
            return response()->json(['success' => true, 'data' => $mahasiswa]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errors' => $e->getMessage()]);
        }
    }

    public function updateActiveStatus(Request $request)
    {
        try {
            $mahasiswa = Mahasiswa::findOrFail(decryptString($request->id));
            $mahasiswa->is_active = !$mahasiswa->is_active;
            DB::beginTransaction();
            if (!empty($mahasiswa->user)) {
                $mahasiswa->user()->update(['is_active' => !$mahasiswa->user->is_active]);
            }
            $mahasiswa->save();
            DB::commit();
            return response()->json(['success' => 'Berhasil mengupdate data mahasiswa', 'updatedstatus' => $mahasiswa->is_active], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
