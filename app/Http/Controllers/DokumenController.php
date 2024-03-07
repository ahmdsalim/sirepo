<?php

namespace App\Http\Controllers;

use App\Imports\DokumenImport;
use App\Models\Jenis;
use App\Models\Dokumen;
use App\Models\Download;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\HashIdService;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['jenis'] = Jenis::select('id', 'nama_jenis')->get();
        return view('dokumen.index', $data);
    }

    public function getDocuments(Request $request)
    {
        $documents = Dokumen::with('jenis')->with('user');
        if (auth()->user()->role == 'admin') {
            $user = auth()->user();
            $documents = Dokumen::with('jenis')
                ->with('user')
                ->whereHas('user', function ($query) use ($user) {
                    $query->where('kode_prodi', $user->kode_prodi);
                });
        }

        return DataTables::eloquent($documents)
            ->editColumn('penulis', function ($row) {
                return Str::limit($row->penulis, 50, '...');
            })
            ->addColumn('action', function ($row) {
                $actionBtn =
                    '<button class="btn btn-success btn-sm" data-id="' .
                    $row->hash_id .
                    '" id="btnShow">Lihat</button>
                    <a class="btn btn-primary btn-sm" href="' .
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

    public function destroyFile(Request $request, string $id)
    {
        try {
            $dokumen = Dokumen::findOrFail($id);
            if (count($dokumen->file) === 0) {
                throw new \Exception('Required at least one file document', 422);
            }

            $indexFile = (new HashIdService())->decode($request->fileid);
            $destination = 'file-penelitian/';
            Storage::delete($destination . $dokumen->file[$indexFile]);
            $files = collect($dokumen->file)
                ->forget($indexFile)
                ->values()
                ->all();
            $dokumen->file = json_encode($files);
            $dokumen->save();

            return response()->json(['success' => 'Berhasil menghapus data'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function getDocumentById(Request $request)
    {
        try {
            $id = (new HashIdService())->decode($request->id);
            $dokumen = Dokumen::with(['jenis:id,nama_jenis', 'user:username,nama'])
                ->withSum('downloads', 'total')
                ->findOrFail($id);

            return response()->json(['success' => 'Berhasil mengambil data', 'data' => $dokumen], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function getFile(Request $request, string $filename)
    {
        $isFileExist = Storage::disk('local')->exists('file-penelitian/' . $filename);
        if ($isFileExist) {
            if ($request->query('download')) {
                // Temukan dokumen berdasarkan file name
                $dokumen = Dokumen::whereJsonContains('file', $filename)->first();

                $download = Download::where('dokumen_id', $dokumen->id)
                    ->whereDate('created_at', date('Y-m-d'))
                    ->first();

                if (!$download) {
                    // Jika tidak ada entri unduhan, buat yang baru
                    $download = new Download();
                    $download->dokumen_id = $dokumen->id;
                    $download->total = 1;
                    $download->save();
                } else {
                    // Jika ada, tingkatkan total unduhan
                    $download->total = $download->total + 1;
                    $download->save();
                }

                return Storage::download('file-penelitian/' . $filename);
            } else {
                // Retrieve the file from storage
                $file = Storage::disk('local')->get('file-penelitian/' . $filename);

                // Return the file as response
                return response($file, 200)->header('Content-Type', 'application/pdf');
            }
        }
        // Throw a 404 Not Found exception
        throw new NotFoundHttpException('File not found.');
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
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => 'required|string|min:15|max:250',
                'abstrak' => 'required|string|min:100',
                'keyword' => 'required|string|min:3',
                'penulis' => 'required|string|min:3',
                'pembimbing' => 'required|string|min:3',
                'penguji' => 'required|string|min:3',
                'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
                'jenis' => 'required|string',
                'files' => 'nullable',
                'files.*' => 'file|mimes:pdf|max:10240',
                'filenames' => 'required_with:files',
                'filenames.*' => 'string|regex:/^[a-zA-Z0-9_\-\s]+$/|max:50',
            ],
            [
                'filenames.*.regex' => 'Nama file hanya boleh mengandung huruf, angka, spasi, _ (underscore), dan - (dash)',
            ],
        );

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
            $dokumen->pembimbing = $validData['pembimbing'];
            $dokumen->penguji = $validData['penguji'];
            $dokumen->tahun = $validData['tahun'];
            $dokumen->jenis_id = (new HashIdService())->decode($validData['jenis']);
            $dokumen->username = auth()->user()->username;

            $fileuploaded = [];
            $totalUploaded = $request->totalUploaded;
            $filenamesLength = $request->filenames === null ? 0 : count($request->filenames);
            if ($totalUploaded == $filenamesLength && $totalUploaded != 0 && $filenamesLength != 0) {
                $filenames = $request->filenames;
                for ($i = 0; $i < $totalUploaded; $i++) {
                    if ($request->hasFile('files.' . $i)) {
                        $destination = 'file-penelitian';
                        $file = $request->file('files.' . $i);
                        $filename = $filenames[$i] . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs($destination, $filename);
                        array_push($fileuploaded, $filename);
                    }
                }
                $dokumen->file = json_encode($fileuploaded);
            }

            $dokumen->save();

            // return response()->json(['success' => 'Berhasil menambah data', 'data' => $dokumen], 200);
            return response()->json(['success' => 'Berhasil menambah data'], 200);
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
        $jenis = Jenis::select('id', 'nama_jenis')->get();
        return view('dokumen.form-dokumen', compact('dokumen', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => 'required|string|min:15|max:250',
                'abstrak' => 'required|string|min:100',
                'keyword' => 'required|string|min:3',
                'penulis' => 'required|string|min:3',
                'pembimbing' => 'required|string|min:3',
                'penguji' => 'required|string|min:3',
                'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
                'jenis' => 'required|string',
                'files' => 'nullable',
                'files.*' => 'file|mimes:pdf|max:10240',
                'filenames' => 'required_with:files',
                'filenames.*' => 'string|regex:/^[a-zA-Z0-9_\-\s]+$/|max:50',
            ],
            [
                'filenames.*.regex' => 'Nama file hanya boleh mengandung huruf, angka, spasi, _ (underscore), dan - (dash)',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $validData = $validator->validated();
            $dokumen = Dokumen::findOrFail($id);
            $dokumen->judul = $validData['judul'];
            $dokumen->abstrak = $validData['abstrak'];
            $dokumen->keyword = $validData['keyword'];
            $dokumen->penulis = $validData['penulis'];
            $dokumen->pembimbing = $validData['pembimbing'];
            $dokumen->penguji = $validData['penguji'];
            $dokumen->tahun = $validData['tahun'];
            $dokumen->jenis_id = (new HashIdService())->decode($validData['jenis']);
            $dokumen->username = auth()->user()->username;

            $fileuploaded = $dokumen->file;
            if ($request->file('files') && $request->filenames) {
                $totalFilesUploaded = count($request->file('files'));
                $filenamesLength = count($request->filenames);
                if ($totalFilesUploaded == $filenamesLength) {
                    $filenames = $request->filenames;
                    foreach ($request->file('files') as $i => $file) {
                        $destination = 'file-penelitian';
                        $filename = $filenames[$i] . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $file->storeAs($destination, $filename);
                        array_push($fileuploaded, $filename);
                    }

                    $dokumen->file = json_encode($fileuploaded);
                }
            }

            $dokumen->save();
            return to_route('dokumens.index')->with('success', 'Berhasil mengubah data');
        } catch (\Exception $e) {
            return back()->with('failed', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dokumen = Dokumen::findOrFail($id);

            // Check if files exist before attempting to delete
            if ($dokumen->file) {
                $destination = 'file-penelitian/';
                foreach ($dokumen->file as $i => $file) {
                    Storage::delete($destination . $dokumen->file[$i]);
                }
            }

            $dokumen->delete();

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

        // Pass the file path to the import method
        $import = new DokumenImport();
        $import->import($file, null, \Maatwebsite\Excel\Excel::XLSX);
        // dd($import);

        if ($import->failures()->isNotEmpty()) {
            return redirect()->route('dokumens.errorImport')->withFailures($import->failures());
        }

        if ($import->getRowCount() == 0) {
            return back()->with('failed', 'Import Gagal: Data tidak ditemukan');
        }
        return to_route('dokumens.index')->with('success', 'Import Data Dokumen Berhasil');
    }

    public function errorImport()
    {
        return view('dokumen.error-import');
    }
}
