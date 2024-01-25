<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Rating;
use App\Models\Kategori;
use PDF;
use App\Exports\ExportBuku;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Exports\ExportDetailBuku;
use App\Exports\ExportReqPosting;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tittle = 'Buku';
        $header = 'Data ' . $tittle;
        $kosong = '';
        $status = '';

        if (Auth::user()->role === 'owner') {
            //jika masuk sebagai owner
            if ($request->has('search')) {
                $data = Buku::where('judul', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('no_isbn', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('penulis', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('penerbit', 'LIKE', '%' . $request->search . '%')
                    ->orderBy('status', 'desc')
                    ->orderBy('judul', 'asc')
                    ->paginate(25);

                if ($data->isEmpty()) {
                    $kosong = 'Data tidak tersedia';
                }
            } else {
                $data = Buku::where('status', 'publish') // Tidak mengambil data dengan status 'pending'
                    ->orderBy('status', 'desc')
                    ->orderBy('judul', 'asc') // Mengurutkan berdasarkan judul buku secara ascending
                    ->paginate(25);

                if ($data->isEmpty()) {
                    $kosong = 'Data tidak tersedia';
                }
            }
        } else {
            //jika masuk sebagai sekolah

            if ($request->has('search')) {
                $data = Buku::where('judul', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('no_isbn', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('penulis', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('penerbit', 'LIKE', '%' . $request->search . '%')
                    ->orderBy('publish', 'desc')
                    ->orderBy('judul', 'asc')
                    ->paginate(25);

                if ($data->isEmpty()) {
                    $kosong = 'Data tidak tersedia';
                }
            } else {
                $emailPengguna = Auth::user()->email; //ambil email dari user

                $data = Buku::Where('email', $emailPengguna)
                    ->orderBy('status', 'asc')
                    ->orderBy('judul', 'asc')
                    ->paginate(25);

                if ($data->isEmpty()) {
                    $kosong = 'Data tidak tersedia';
                }
            }
        }

        return view('buku.buku', compact('data', 'tittle', 'header', 'kosong', 'status'));
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */

    public function request()
    {
        $tittle = 'Buku';
        $header = 'Data ' . $tittle;
        $kosong = '';

        $data = Buku::where('status', 3)->paginate(25);
        if ($data->isEmpty()) {
            $kosong = 'Data tidak tersedia';
        }

        return view('buku.request', compact('data', 'tittle', 'header', 'kosong'));
    }

    public function requestUpdate($id)
    {
        $buku = Buku::find($id);

        if ($buku) {
            $action = request('action'); // Ambil nilai dari input dengan name "action"

            if ($action === 'tolak') {
                $buku->status = 2;
            } else {
                $buku->status = 1; // Ubah sesuai kebutuhan jika status harus berbeda
            }

            $buku->save();

            return redirect()
                ->back()
                ->with('success', 'Buku telah diperbarui.');
        }

        return redirect()
            ->back()
            ->with('error', 'Buku tidak ditemukan.');
    }

    public function resend($id)
    {
        $buku = Buku::find($id);

        if ($buku) {
            $action = request('action'); // Ambil nilai dari input dengan name "action"

            if ($action === 'resend') {
                $buku->status = 'pending';
            }

            $buku->save();

            return redirect()
                ->back()
                ->with('success', 'Buku telah Di Ajukan Ulang.');
        }

        return redirect()
            ->back()
            ->with('error', 'Buku tidak ditemukan.');
    }

    public function create()
    {
        $tittle = 'Buku';
        $header = 'Tambah ' . $tittle;

        $kategori = Kategori::all();

        return view('buku.tambah-buku', compact('tittle', 'header', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_isbn' => 'required|unique:bukus',
                'judul' => 'required|',
                'foto' => 'max:1000',
                'kategori_id' => 'required|',
                'pengarang' => 'required|',
                'penerbit' => 'required|',
                'tahun_terbit' => 'required|',
                'url_pdf' => 'required|',
            ],
            [
                'no_isbn.unique' => 'no isbn ' . $request->no_isbn . ' sudah digunakan',
                'kategori_id.required' => 'kategori tidak boleh kosong',
                'judul.required' => 'judul tidak boleh kosong',
                'pengarang.required' => 'penarang tidak boleh kosong',
                'penerbit.required' => 'penerbit tidak boleh kosong',
                'tahun_terbit.required' => 'tahun_terbit tidak boleh kosong',
                'no_isbn.required' => 'no_isbn tidak boleh kosong',
                'url_pdf.required' => 'url_pdf tidak boleh kosong',
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $buku = new Buku();
        // $images = []; // Mengganti $slide menjadi $images

        // // upload slide
        // if ($request->hasFile('slide')) {
        //     // Memeriksa apakah ada file slide yang diunggah
        //     foreach ($request->file('slide') as $file) {
        //         $image_name = md5(rand(1000, 10000));
        //         $ext = strtolower($file->getClientOriginalExtension()); // Menggunakan getgetClientOriginalExtension() untuk mendapatkan ekstensi file
        //         $image_full_name = $image_name . '.' . $ext;
        //         $upload_path = 'img/slide/';
        //         $image_url = $upload_path . $image_full_name;
        //         $file->move($upload_path, $image_full_name);
        //         $images[] = $image_url;
        //     }
        // }

        // upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $destination = 'public/imgs/thumbnail-buku/';

            $thumbnail = $request->file('thumbnail');
            $thumbnail_name = md5(rand(1000, 10000)) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->storeAs($destination, $thumbnail_name);
            $buku->thumbnail = $thumbnail_name;
        }

        $destination = 'public/files/buku/';

        $file = $request->file('url_pdf');
        $extension = $file->getClientOriginalExtension();
        $slug = Str::slug(strtolower($request->judul));
        $file_name = $slug . '-' . time() . '.' . $extension;
        $file->storeAs($destination, $file_name);

        // Path lengkap ke file PDF yang diunggah
        $pdfPath = storage_path('app/' . $destination . '/' . $file_name);

        // Menggunakan pdfparser untuk menghitung jumlah halaman
        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $pages = $pdf->getPages();

        // Hitung jumlah halaman
        $pageCount = count($pages);

        $upload_file = $file_name;

        // $buku->slide = implode('|', $images); // Mengganti $image menjadi $images
        $buku->judul = $request->judul;
        $buku->slug = Str::slug(strtolower($buku->judul));
        $buku->penulis = $request->pengarang;
        $buku->penerbit = $request->penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->jumlah_halaman = $pageCount;
        $buku->kategori_id = $request->kategori_id;
        $buku->email = Auth::user()->email;
        $buku->url_pdf = $upload_file;
        $buku->deskripsi = $request->deskripsi;
        $buku->no_isbn = $request->no_isbn;
        if (Auth::user()->role === 'owner') {
            $buku->status = 'publish';
        }
        $buku->save();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data Telah Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     */

    public function show($slug)
    {
        $tittle = 'Buku';
        $header = 'Detail ' . $tittle;

        $buku = Buku::where('slug', $slug)->first();

            $desk_awal = substr($buku->deskripsi, 0, 250);
            $deskripsi = $buku->deskripsi;

            $data['avgRating'] = Rating::where('buku_id', $buku->id)->avg('score');
            $data['countVoter'] = Rating::where('buku_id', $buku->id)->count('email');

            return view('buku.detail-buku', compact('tittle', 'header', 'buku', 'desk_awal', 'deskripsi'), $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tittle = 'Buku';
        $header = 'Edit ' . $tittle;

        $buku = Buku::find($id);
        $kategori = Kategori::all();

        return view('buku.edit-buku', compact('tittle', 'header', 'kategori', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'foto' => 'max:1000',
            ],
            [
                'no_isb.unique' => 'no isbn ' . $request->kategori . ' sudah digunakan',
                'no_isb.required' => 'no isbn tidak boleh kosong',
                'kategori.id.required' => 'kategori tidak boleh kosong',
                'judul.required' => 'judul tidak boleh kosong',
                'penulis.required' => 'penulis tidak boleh kosong',
                'penerbit.required' => 'penerbit tidak boleh kosong',
                'tahun_terbit.required' => 'tahun_terbit tidak boleh kosong',
                'jumlah_halaman.required' => 'jumlah_halaman tidak boleh kosong',
                'no_isbn.required' => 'no_isbn tidak boleh kosong',
                'url_pdf.required' => 'url_pdf tidak boleh kosong',
            ],
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = Buku::findorfail($id);

        // $images = []; // Mengganti $slide menjadi $images

        // // upload slide
        // if ($request->hasFile('slide')) {
        //     // Memeriksa apakah ada file slide yang diunggah
        //     foreach ($request->file('slide') as $file) {
        //         $image_name = md5(rand(1000, 10000));
        //         $ext = strtolower($file->getClientOriginalExtension()); // Menggunakan getgetClientOriginalExtension() untuk mendapatkan ekstensi file
        //         $image_full_name = $image_name . '.' . $ext;
        //         $upload_path = 'img/slide/';
        //         $image_url = $upload_path . $image_full_name;
        //         $file->move($upload_path, $image_full_name);
        //         $images[] = $image_url;
        //     }
        // }

        if ($request->hasFile('thumbnail')) {
            $destination = 'public/imgs/thumbnail-buku/';

            $thumbnail = $request->file('thumbnail');
            $thumbnail_name = $data->thumbnail;
            $thumbnail->storeAs($destination, $thumbnail_name);
            $data->thumbnail = $thumbnail_name;
        }

        $destination = 'files/buku/';

        if ($request->hasFile('url_pdf')) {
            $file = $request->file('url_pdf');
            $extension = $file->getClientOriginalExtension();
            $slug = Str::slug(strtolower($request->judul));
            $file_name = $slug . '-' . time() . '.' . $extension;
            $file->storeAs($destination, $file_name);

            $pdfPath = storage_path('app/' . $destination . '/' . $file_name);
            // Path lengkap ke file PDF yang diunggah

            // Menggunakan pdfparser untuk menghitung jumlah halaman
            $parser = new Parser();
            $pdf = $parser->parseFile($pdfPath);
            $pages = $pdf->getPages();

            // Hitung jumlah halaman
            $pageCount = count($pages);

            $upload_file = $file_name;

            $data->jumlah_halaman = $pageCount;
            $data->url_pdf = $upload_file;
        }

        // $data->slide = implode('|', $images); // Mengganti $image menjadi $images
        $data->judul = $request->judul;
        $data->slug = Str::slug(strtolower($data->judul));
        $data->penulis = $request->penulis;
        $data->penerbit = $request->penerbit;
        $data->tahun_terbit = $request->tahun_terbit;
        $data->kategori_id = $request->kategori_id;
        $data->edited_by = Auth::user()->email;
        $data->deskripsi = $request->deskripsi;
        $data->no_isbn = $request->no_isbn;
        if (Auth::user()->role === 'owner') {
            $data->status = 'publish';
        } else {
            $data->status = 'pending';
        }

        $data->update();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data Telah Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Buku::find($id);
        $data->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data Telah Berhasil Di Hapus');
    }

    public function showdetail($id, $slug)
    {
        $user = Auth::user();
        $buku = Buku::where([['id', $id], ['slug', $slug]])->first() ?? abort(404);

        $data['avgRating'] = Rating::where('buku_id', $buku->id)->avg('score');

        if (isAuth()) {
            $userHasRated = Rating::where('buku_id', $buku->id)
                ->where('email', $user->email)
                ->exists();
        } else {
            $userHasRated = false;
        }
        $data['countVoter'] = Rating::where('buku_id', $buku->id)->count('email');

        // Ubah cara Anda mengakses deskripsi dari model Buku
        $data['desk_awal'] = substr($buku->deskripsi, 0, 250);
        $data['deskripsi'] = $buku->deskripsi;

        // Kemudian, simpan model Buku dalam array data
        $data['buku'] = $buku;

        return view('detailbuku', compact('buku', 'userHasRated'), $data);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $results = Buku::where(function ($query) use ($keyword) {
            $query
                ->where('judul', 'like', "%$keyword%")
                ->orWhere('no_isbn', 'like', "%$keyword%")
                ->orWhere('penulis', 'like', "%$keyword%")
                ->orWhere('penerbit', 'like', "%$keyword%");
        })
            ->where('status', 'publish')
            ->orderBy('judul', 'asc')
            ->paginate(25);

        return view('booksearch', compact('results', 'keyword'));
    }

    public function bukuterbaru(Request $request)
    {
        $buku = Buku::orderBy('created_at', 'desc')->where('status', 'publish')->paginate(12);
        return view('bukuterbaru', compact('buku'));
    }

    public function bukuterpopuler(Request $request)
    {
        $buku = Buku::orderBy('jumlah_baca', 'desc')->where('status', 'publish')->paginate(12);
        return view('bukuterpopuler', compact('buku'));
    }

    public function export()
    {
        return Excel::download(new ExportBuku(), 'daftar-buku-digilib.xlsx');
    }

    public function exportReqPosting()
    {
        return Excel::download(new ExportReqPosting(), 'detail-request-posting-digilib.xlsx');
    }

    public function cetakPdf()
    {
    $user = auth()->user();

    if ($user->role == 'owner') {
        $data = Buku::where('status', 'publish')->get();
    } elseif ($user->role == 'sekolah') {
        $data = Buku::where('email', $user->email)->get();
    }

    view()->share('data', $data);
    $pdf = PDF::loadView('pdf.daftar_buku');
    return $pdf->download('daftar_buku.pdf');
    }
}
