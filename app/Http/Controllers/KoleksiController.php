<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class KoleksiController extends Controller
{
    public function index(){
        $koleksi = Bookmark::with('dokumen')->where('username', auth()->user()->username)->get()->take(12);
        // $dokumen = Dokumen::where('username',auth())->firstOrFail();
        
        return view('landing.koleksi', compact('koleksi'));
        //return view('layouts.main');
        //$koleksi = koleksi::all();
    }
    public function collect(Request $request){
        $username = Auth::user()->username;
        $dokumen_id = Crypt::decryptString($request->id);

        $collection = Bookmark::firstOrNew(['username' => $username, 'dokumen_id' => $dokumen_id]);

        $collection->save();

        if($collection){
            return response()->json(['' ,'message' => 'collected']);
        }

        return response()->json(['message' => 'Dokumen gagal dimasukan kedalam koleksi']);
    }

    public function uncollect(Request $request)
    {
        $username = Auth::user()->username;
        $dokumen_id = Crypt::decryptString($request->id);

        $collection = Bookmark::where('username',$username)->where('dokumen_id',$dokumen_id)->delete();

        if($collection){
            return response()->json(['message' => 'collected']);
        }

        return response()->json(['message' => 'Dokumen gagal dimasukan kedalam koleksi']);
    }
}
