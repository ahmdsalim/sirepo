<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TokenAktivasi;
use Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Events\UserActivated;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth', ['only' => 'index']);
        $this->middleware('role:owner', ['only' => ['create','store','edit','show','update','destroy']]);
    }

    public function index(Request $request)
    {
        if (Auth::user()->role === 'owner') {
            $query = User::query();
            $data['search'] = $request->input('search');
            $search = $data['search'];
            if ($request->has('search') && !empty($request->input('search'))) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('email', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                });
            }

            $data['users'] = $query->orderBy('created_at','desc')->paginate(25);
            return view('owner.user.user', $data);
        } elseif (Auth::user()->role === 'sekolah') {
            $title = 'User';
            $header = 'Data ' . $title;

            $user = Auth::user();
            $npsn = $user->userable->npsn;
            $query = User::query()
                ->whereHas('userable', function ($query) use ($npsn) {
                    $query->where('npsn', $npsn);
                })
                ->whereIn('role', ['siswa', 'guru']); // Menggunakan whereIn untuk role siswa dan guru

            $data['search'] = $request->input('search');
            $search = $data['search'];

            if ($request->has('search') && !empty($request->input('search'))) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('email', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                });
            }

            $data['users'] = $query->orderBy('created_at', 'desc')->paginate(25);

            return view('sekolah.user.user', compact('title', 'header'), $data);
        } else {
            abort(401);
        }
    }

    public function showProfile()
    {
        return view('profile.admin.index');
    }

    public function showProfilePembaca()
    {
        return view('profile.user.index');
    }

    public function showChangePassword()
    {
        return view('profile.admin.change-password');
    }

    public function showChangePasswordPembaca()
    {
        return view('profile.user.change-password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|confirmed|min:8|different:password',
        ]);

        if (!$validator->fails()) {
            $user = Auth::user();
            if (\Hash::check($request->password, $user->password)) {
                $user
                    ->fill([
                        'password' => $request->new_password,
                    ])
                    ->save();
                $routename = $user->role === 'owner' ? 'home' : 'home.sekolah';
                return to_route($routename)->with('success', 'Berhasil mengubah password');
            }
            $validator->getMessageBag()->add('password', 'Password does not match');
        }
        return redirect()
            ->back()
            ->withErrors($validator);
    }

    public function changePasswordPembaca(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'new_password' => 'required|confirmed|min:8|different:password',
        ]);

        if (!$validator->fails()) {
            $user = Auth::user();
            if (\Hash::check($request->password, $user->password)) {
                $user
                    ->fill([
                        'password' => $request->new_password,
                    ])
                    ->save();

                return to_route('home')->with('success', 'Berhasil mengubah password');
            }
            $validator->getMessageBag()->add('password', 'Password does not match');
        }
        return redirect()
            ->back()
            ->withErrors($validator);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.user.form-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:128',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|string|in:owner,sekolah,siswa,guru',
            'userable' => 'required_if:role,sekolah,siswa,guru',
            'active' => 'required|in:1,0',
        ]);

        if (!$validator->fails()) {
            $data = $validator->validated();
            $new = [
                'nama' => $data['nama'],
                'uuid' => generateUuid(),
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => $data['role'],
                'active' => $data['active'],
            ];

            if (in_array($data['role'], ['sekolah', 'siswa', 'guru'])) {
                $new['userable_id'] = $data['userable'];
                $new['userable_type'] = getmodelClass($data['role']);
            }

            $saved = User::create($new);

            if (!$saved) {
                return to_route('users.index')->with('failed', 'Gagal');
            }
            return to_route('users.index')->with('success', 'Berhasil');
        } else {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $data['user'] = $user;
        return view('owner.user.show-user', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data['user'] = $user;
        return view('owner.user.form-user', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:128',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|string|in:owner,sekolah,siswa,guru',
            'userable' => 'required_if:role,sekolah,siswa,guru',
            'active' => 'required|in:1,0',
        ]);

        if ($validator->passes()) {
            $data = $validator->validated();
            $new = [
                'nama' => $data['nama'],
                'email' => $data['email'],
                'role' => $data['role'],
                'active' => $data['active'],
            ];

            !empty($data['password']) ?? ($new['password'] = $data['password']);

            if ($data['role'] === 'owner' && in_array($user->role, ['sekolah', 'siswa', 'guru'])) {
                $new['userable_id'] = null;
                $new['userable_type'] = null;
            } elseif ($user->role === 'owner' && in_array($data['role'], ['sekolah', 'siswa', 'guru'])) {
                $new['userable_id'] = $data['userable'];
                $new['userable_type'] = getmodelClass($data['role']);
            }else {
                $new['userable_id'] = $data['userable'];
                $new['userable_type'] = getmodelClass($data['role']);
            }

            $saved = $user->update($new);

            if (!$saved) {
                return to_route('users.index')->with('failed', 'Gagal');
            }
            
            return to_route('users.index')->with('success', 'Berhasil');
        } else {
            return redirect()
                ->back()
                ->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $delete = $user->delete();

        if (!$delete) {
            return to_route('users.index')->with('failed', 'Gagal');
        }
        return to_route('users.index')->with('success', 'Berhasil');
    }

    public function aktivasi(Request $request)
    {
        $token = $request->query('token');

        if (isset($token)) {
            DB::beginTransaction();

            try {
                $aktivasi = TokenAktivasi::where('token', $token)->first();

                if ($aktivasi) {
                    $user = User::where('email', $aktivasi->email)->update(['active' => 1]);

                    $datauser = User::where('email', $aktivasi->email)->first();

                    event(new UserActivated($datauser));

                    $aktivasi->delete();
                        
                    DB::commit();
                        
                    $request->session()->now('alert-class', 'alert-success');
                    $request->session()->now('message', 'Akun berhasil diaktivasi! Silahkan masuk ke akun anda. <a href='.route('login').'>Klik disini</a>.');

                    return view('auth.aktivasi');
                }
            } catch(\Exception $e) {
                DB::rollback();
                $request->session()->now('alert-class', 'alert-danger');
                $request->session()->now('message', 'Terjadi Kesalahan. Silahkan coba kembali');
                return view('auth.aktivasi');
            }
        }
        $request->session()->now('alert-class', 'alert-info');
        $request->session()->now('message', '<b>Token tidak dikenali</b><br>Pastikan melakukan aktivasi melalui pesan email yang telah diberikan.');
        return view('auth.aktivasi');
    }

    public function export(){
        return Excel::download(new ExportUser, 'daftar-pengguna.xlsx');
    }

    public function cetakPdf()
    {
        $data = User::all();
        view()->share('data', $data);
        $pdf = PDF::loadview('pdf.daftar_user');
        return $pdf->download('daftar_user.pdf');
    }
}
