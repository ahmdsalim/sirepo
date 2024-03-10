<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
            'npm' => [
                'required',
                function ($attribute, $value, $fail) use ($data) {
                    $mhs = Mahasiswa::where('npm', $data['npm'])
                        ->where('email', $data['email'])
                        ->where('is_active', true)
                        ->doesntHave('user')->count();
                    if ($mhs === 0) {
                        $fail('NPM tidak terdaftar.');
                    }
                }
            ],
            'email' => 'required|email',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request, $password)
    {
        $mhs = Mahasiswa::findOrFail($request->npm);
        return User::create([
            'nama' => $mhs->nama_mahasiswa,
            'email' => $mhs->email,
            'username' => $request->npm,
            'npm' => $request->npm,
            'role' => 'user',
            'is_active' => $mhs->is_active,
            'password' => Hash::make($password),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        try {
            $rawpassword = strtolower(Str::random(8));
            DB::beginTransaction();
            $user = $this->create($request, $rawpassword);
            $data = [
                'email' => $user->email,
                'nama' => $user->nama,
                'username' => $user->username,
                'password' => $rawpassword
            ];

            event(new Registered($data));

            if ($response = $this->registered($request)) {
                DB::commit();
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('failed', 'Gagal mendaftar : Terjadi kesalahan pada server');
        }
    }

    protected function registered(Request $request)
    {
        return to_route('login')->with('success', 'Pendaftaran akun berhasil. Silahkan cek pesan email yang telah dikirimkan');
    }
}
