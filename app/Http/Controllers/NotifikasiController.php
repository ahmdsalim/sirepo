<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
    	return view('inbox');
    }

    public function show($id)
    {
    	$notif = Notifikasi::findOrFail(\Crypt::decryptString($id));
    	if(!$notif->is_read){
    		$notif->update(['is_read' => true]);
    	}
    	return view('inbox-show', compact('notif'));
    }

    public function destroy($id)
    {
    	try {
	    	$notif = Notifikasi::findOrFail(\Crypt::decryptString($id));
	    	$notif->delete();
	    	return back()->with('success', 'Berhasil menghapus notifikasi');
    	} catch (\Exception $e) {
	    	return to_route('inbox.index')->with('failed', 'Gagal menghapus notifikasi');
    	}
    }
}
