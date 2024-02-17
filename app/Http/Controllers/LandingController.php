<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis = Jenis::all();
        // $data['CProyek2'] = Dokumen::where('jenis_id',1)->count();
        // $data['CProyek1'] = Dokumen::where('jenis_id',2)->count();
        // $data['CTA'] = Dokumen::where('jenis_id',3)->count();
        return view('landing.landing',compact('jenis'));
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
        //
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

    public function profile(){
        $user = Auth::user();
        return view ('landing.profile',compact('user'));
    }

    public function setting(){
        $user = Auth::user();
        return view ('landing.setting.profile',compact('user'));
    }

    public function keamanan(){
        $user = Auth::user();
        return view ('landing.setting.keamanan',compact('user'));
    }

    public function search(){
        return view('landing.result');
    }
}
