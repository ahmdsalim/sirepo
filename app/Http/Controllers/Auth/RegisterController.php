<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
{
    return Validator::make($data, [
        'nama' => 'required|string|min:2|max:255',
        // 'email' => 'required|email|unique:users,email',
        // 'username' => 'required|string|min:5|max:100|unique:users,username',
        // 'role' => 'required|in:super,admin,user',
        // 'verifikasi_file' => 'required|file', 
        // 'password' => 'required|string|min:8|max:150', 
    ]);
}


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $terverifikasi = false;

        if (auth()->check() && auth()->user()->role !== 'user') {
            $terverifikasi = true;
        }

        return User::create([
            'nama' => $data['nama'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => 'user',
            'verifikasi_file' => $data['verifikasi_file'],
            'terverifikasi' => $terverifikasi,
            'password' => Hash::make($data['password']),
        ]);
    }
}
