<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [];
        if (auth()->user()->role == 'super') {
            $data['totalUser'] = User::onlyuser()->count();
            $data['totalApproved'] = User::onlyuser()->approved()->count();
            $data['totalModeration'] = User::onlyuser()->toapprove()->count();
        }
        if (in_array(auth()->user()->role, ['super', 'admin'])) {
            $data['totalDocument'] = Dokumen::count();
            if (auth()->user()->role == 'admin') {
                $data['totalDocument'] = Dokumen::onlyLogged()->count();
            }
        }
        return view('home', $data);
    }
}
