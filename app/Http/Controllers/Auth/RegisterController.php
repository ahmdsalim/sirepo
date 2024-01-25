<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\TokenAktivasi;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Mail\SendEmailAktivasi;
use Str;
use Illuminate\Validation\Rule;
use App\Events\UserRegistered;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showFormSekolah()
    {
        return view('auth.register-sekolah');
    }

    public function registerSekolah(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'npsn' => 'required|numeric|unique:sekolahs,npsn',
            'nama' => 'required|max:120',
            'jenjang' => 'required|string',
            'alamat' => 'required|string|max:120',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'telepon' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();

            \DB::beginTransaction();

            try{
                $sekolah = Sekolah::create([
                    'npsn' => $data['npsn'],
                    'nama' => Str::title($data['nama']),
                    'jenjang' => $data['jenjang'],
                    'alamat' => $data['alamat'],
                    'provinsi' => $data['provinsi'],
                    'kota' => $data['kota'],
                    'kecamatan' => $data['kecamatan'],
                    'kelurahan' => $data['kelurahan'],
                    'telepon' => $data['telepon']
                ]);

                $user = new User([
                    'uuid' => generateUuid(),
                    'email' => $data['email'],
                    'nama' => Str::title($data['nama']),
                    'password' => $data['password'],
                    'role' => 'sekolah'
                ]);

                    $user = $sekolah->user()->save($user);

                    event(new UserRegistered($user));

                    // $emaildata = [
                    //         'nama' => $data['nama'],
                    //         'subject' => 'Welcome to DIGILIB!'
                    // ];

                    // $email = new SendEmail($emaildata);
                    // Mail::to($data['email'])->send($email);

                    $key = generateUuid();
                    \Cookie::queue($key, $data['email'], 10);

                    \DB::commit();

                    return redirect()->route('login.action',['key'=>$key,'act'=>'after-registration']);
            } catch(\Exception $e) {
                \DB::rollback();

                return redirect()->back()->with(['alert-class' => 'alert-danger', 'message' => 'Terjadi kesalahan, coba kembali dalam beberapa saat lagi.']);
            }                 
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function showFormSiswa()
    {
        $data['sekolahs'] = Sekolah::whereHas('user', function ($query) {
                                $query->where('active', 1);
                            })->get();
        return view('auth.register-siswa', $data);
    }

    public function registerSiswa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => [
                'required',
                function($attribute, $value, $fail) use ($request) {
                    $siswas = Siswa::where('nisn', $request->nisn)
                                   ->where('npsn', $request->sekolah)
                                   ->doesntHave('user')->count();
                    if($siswas <= 0){
                        $fail('This nisn has not been identified.');
                    }
                }
            ],
            'sekolah' => 'required|exists:sekolahs,npsn',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $siswa = Siswa::where('nisn',$data['nisn'])->firstOrFail();

            \DB::beginTransaction();

            try{
                $user = new User([
                    'uuid' => generateUuid(),
                    'email' => $data['email'],
                    'nama' => Str::title($siswa->nama),
                    'password' => $data['password'],
                    'role' => 'siswa'
                ]);

                $user = $siswa->user()->save($user);

                
                    $token = Str::random(64);

                    TokenAktivasi::insert([
                        'token' => $token,
                        'email' => $user->email
                    ]);

                    event(new UserRegistered($user, $token));

                    // $emaildata = [
                    //     'nama' => $user->nama,
                    //     'subject' => 'Aktivasi Akun ('.$user->nama.')',
                    //     'token' => $token
                    // ];

                    // $email = new SendEmailAktivasi($emaildata);
                    // Mail::to($data['email'])->send($email);

                    $key = generateUuid();
                    \Cookie::queue($key, $data['email'], 10);

                    \DB::commit();

                    return redirect()->route('login.action',['key'=>$key,'act'=>'email-verification']);
            } catch(\Exception $e) {
                \DB::rollback();

                return redirect()->back()->with(['alert-class' => 'alert-danger', 'message' => 'Terjadi kesalahan, coba kembali dalam beberapa saat lagi.']);
            }
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function showFormGuru()
    {
        $data['sekolahs'] = Sekolah::whereHas('user', function ($query) {
                                $query->where('active', 1);
                            })->get();
        return view('auth.register-guru', $data);
    }

    public function registerGuru(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => [
                'required',
                function($attribute, $value, $fail) use ($request) {
                    $gurus = Guru::where('nip', $request->nip)
                                   ->where('npsn', $request->sekolah)
                                   ->doesntHave('user')->count();
                    if($gurus <= 0){
                        $fail('The selected nip is invalid.');
                    }
                }
            ],
            'sekolah' => 'required|exists:sekolahs,npsn',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        if(!$validator->fails()){
            $data = $validator->validated();
            $guru = Guru::where('nip',$data['nip'])->firstOrFail();

            \DB::beginTransaction();

            try{
                $user = new User([
                    'uuid' => generateUuid(),
                    'email' => $data['email'],
                    'nama' => Str::title($guru->nama),
                    'password' => $data['password'],
                    'role' => 'guru'
                ]);

                $user = $guru->user()->save($user);

                    $token = Str::random(64);

                    TokenAktivasi::insert([
                        'token' => $token,
                        'email' => $user->email
                    ]);

                    event(new UserRegistered($user, $token));

                    // $emaildata = [
                    //     'nama' => $user->nama,
                    //     'subject' => 'Aktivasi Akun ('.$user->nama.')',
                    //     'token' => $token
                    // ];

                    // $email = new SendEmailAktivasi($emaildata);
                    // Mail::to($data['email'])->send($email);

                    $key = generateUuid();
                    \Cookie::queue($key, $data['email'], 10);

                    \DB::commit();

                    return redirect()->route('login.action',['key'=>$key,'act'=>'email-verification']);
            } catch(Exception $e) {
                \DB::rollback();

                return redirect()->back()->with(['alert-class' => 'alert-danger', 'message' => 'Terjadi kesalahan, coba kembali dalam beberapa saat lagi.']);
            }
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function showResend()
    {
        return view('auth.resend');
    }

    public function resendEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                Rule::exists('users')->where(function($query) use ($request) {
                    return $query->where('email', $request->email)
                                 ->where('active', 0)
                                 ->whereIn('role',['siswa','guru']);
                })
            ]
        ]);

        $aktivasi = TokenAktivasi::where('email', $request->email)->first();
        if($aktivasi){
            $emaildata = [
                'nama' => $aktivasi->user->nama,
                'subject' => 'Aktivasi Akun ('.$aktivasi->user->nama.')',
                'token' => $aktivasi->token
            ];

            $email = new SendEmailAktivasi($emaildata);
            Mail::to($request->email)->send($email);
            return redirect()->back()->with('resend', true);
        }

        return redirect()->back()->with('message', 'Email yang anda masukkan tidak terdaftar atau sudah diaktivasi sebelumnya.');
    }

    // public function showResetEmail()
    // {
    //     return view('auth.reset-email');
    // }

    // public function resetEmail(Request $request)
    // {
    //     $validator = Validator::make($request->all(),[
    //         'email' => [
    //             'required',
    //             'email',
    //             Rule::exists('users')->where(function($query) use ($request){
    //                 return $query->where('active', 0);
    //             })
    //         ],
    //         'new_email' => 'required|email|unique:users,email,'.$request->email,
    //         'password' => 'required'
    //     ]);

    //     if(!$validator->fails()){
    //         $user = User::where('email',$request->email)->first();

    //         if($user && Hash::check($request->password, $user->password)){
    //             $aktivasi = TokenAktivasi::where('email', $request->email)->first();
                
    //             if($aktivasi){
    //                 $emaildata = [
    //                     'nama' => $aktivasi->user->nama,
    //                     'subject' => 'Aktivasi Akun ('.$aktivasi->user->nama.')',
    //                     'token' => $aktivasi->token
    //                 ];

    //                 $user->update(['email' => $request->new_email]);
    //                 $email = new SendEmailAktivasi($emaildata);
    //                 Mail::to($request->new_email)->send($email);
    //                 return redirect()->back()->with('reset', true);
    //             }
    //         }else{
    //             return redirect()->back()->with('message','Email yang Anda masukkan tidak dikenali.');
    //         }
    //     }
    //     return redirect()->back()->withErrors($validator)->withInput();
    // }

    public function login_action(Request $request)
    {
        $key = $request->query('key');
        $action = $request->query('act');

        $data = [
            'title' => 'Kami mohon maaf...',
            'action' => 'cookie not found'

        ];

        if($key != null && $action != null){
            if(\Cookie::has($key)){
                $email = \Cookie::get($key);
                if($action == 'email-verification'){
                    $data['title'] = 'Verifikasi Email';
                    $data['action'] = 'verifikasi-email';
                    $data['message'] = 'Anda perlu memverifikasi alamat email untuk mengaktifkan akun anda.';
                    $data['info'] = 'Sebuah email dengan instruksi untuk memverifikasi email anda telah dikirim ke alamat email '.$email.'.';
                }else if ($action == 'after-registration') {
                    $data['title'] = 'Pendaftaran Berhasil';
                    $data['message'] = 'Periksa alamat email anda untuk informasi lebih lanjut.';
                    $data['info'] = 'Sebuah email dengan informasi untuk langkah selanjutnya telah dikirim ke alamat email '.$email.'.';
                    $data['action'] = 'more-info';
                }

            }
        }

        return view('auth.login-action', $data);
    }

}
