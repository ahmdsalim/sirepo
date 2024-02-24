<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

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
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|min:5|max:100|not_in:admin,super,user|unique:users,username',
            'password' => 'required|string|min:8|max:150',
            'ktm' => 'required|file|mimes:pdf,jpg,jpeg,png,heic|max:2048',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        $file = $request->file('ktm');
        $destination = '/public/file-verifikasi';
        $filename = 'ktm_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($destination, $filename);

        return User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'role' => 'user',
            'verifikasi_file' => $filename,
            'terverifikasi' => false,
            'password' => Hash::make($request->password),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request)));

        if ($response = $this->registered($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    protected function registered(Request $request)
    {
        return to_route('login')->with('success', 'Berhasil mendaftar akun');
    }
}
