<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function authenticated(Request $request, $user)
    {
        if($user->role == 'owner') {
            return to_route('home');
        } elseif ($user->role == 'sekolah') {
            return to_route('home.sekolah');
        } elseif($user->role == 'siswa' || $user->role == 'guru') {
            return redirect('/');
        }else{
            Auth::user()->logout();
            return to_route('login')->with('error','Anda tidak memiliki akses');
        }
    }

    protected function credentials(Request $request)
    {
        $creds = $request->only($this->username(), 'password');
        $creds['active'] = 1;
        return $creds;
    }

    protected function loggedOut(Request $request)
    {
        return to_route('login');
    }
    
}
