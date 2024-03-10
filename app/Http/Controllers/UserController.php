<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodis = Prodi::select('kode_prodi', 'nama_prodi')->get();
        return view('super.users.index', compact('prodis'));
    }

    public function getUsers(Request $request)
    {
        $users = User::with('mahasiswa:npm,email,kode_prodi')->exceptlogged()->latest()->get();
        return DataTables::of($users)
            ->addColumn('action', function ($row) {
                $color = $row->is_active ? 'secondary' : 'success';
                $text = $row->is_active ? 'Nonaktifkan' : 'Aktifkan';
                $actionBtn = '<button type="button" class="btn btn-' . $color . ' text-white btn-sm activate-button" data-id="' . encryptString($row->username) . '" id="btnActivate">
                ' . $text . '
            </button>
            <a class="btn btn-primary btn-sm" href="' . route("users.edit", ["user" => $row->username]) . '">Edit</a>
                <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="' . $row->username . '" id="btnDelete">
                    Hapus
                </button>';
                if ($row->role === 'super') {
                    $actionBtn = '<span class="small text-muted fst-italic">View only</span>';
                }
                return $actionBtn;
            })
            ->editColumn('created_at', function ($row) {
                return '<span class="small text-muted">' . $row->created_at->format('d-m-Y H:i') . '</span>';
            })
            ->rawColumns(['role', 'action', 'created_at'])
            ->make(true);
    }

    public function profile()
    {
        $user = auth()->user();
        return view('akun.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            $rules = [
                'nama' => 'required|string|min:2|max:150'
            ];
            if ($user->role === 'user') {
                $rules['email'] = [
                    'required',
                    'email',
                    Rule::unique('mahasiswas')->ignore($user->npm, 'npm'),
                    Rule::unique('users')->ignore($user->username, 'username')
                ];
            } else {
                $rules['email'] = [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->username, 'username'),
                    Rule::unique('mahasiswas')
                ];
            }
            $validator = Validator::make($request->all(), $rules);


            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $data = $validator->validated();
            $user->nama = $data['nama'];
            $user->email = $data['email'];
            DB::beginTransaction();
            if ($user->role === 'user') {
                $user->mahasiswa()->update(['email' => $data['email']]);
            } else {
                $user->email = $data['email'];
            }
            $user->save();
            DB::commit();
            return response()->json(['success' => 'Berhasil mengupdate profile', 'data' => ['nama' => $data['nama']]]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => 'Gagal mengupdate profile : ' . $e->getMessage()], 500);
        }
    }

    public function security()
    {
        return view('akun.keamanan.index');
    }

    public function securityUpdate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'password_confirmation' => 'required',
                'password' => 'required|confirmed|min:8|different:current_password',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $data = $validator->validated();
            $user = Auth::user();
            if (Hash::check($data['current_password'], $user->password)) {
                $user->fill([
                    'password' => Hash::make($data['password'])
                ])->save();

                return response()->json(['success' => 'Berhasil mengupdate password']);
            }
            return response()->json(['errors' => ['current_password' => [
                "Password does not match"
            ]]], 422);
        } catch (\Exception $e) {
            return response()->json(['errors' => 'Gagal mengupdate password : ' . $e->getMessage()], 422);
        }
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
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required_if:role,admin|string|min:2|max:150',
                'email' => [
                    'required_if:role,admin', 'email',
                    Rule::unique('users', 'email'),
                    Rule::unique('mahasiswas', 'email')
                ],
                'username' => [
                    'required_if:role,admin', 'string', 'min:5', 'max:100',
                    Rule::unique('users', 'username'),
                    Rule::unique('mahasiswas', 'npm')
                ],
                'prodi' => 'required_if:role,admin|string',
                'password' => 'required|string|min:8|max:150',
                'role' => 'required|in:admin,user',
                'mahasiswa' => 'required_if:role,user'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $validData = $validator->validated();
            $data = [
                'password' => $validData['password'],
                'is_active' => true,
                'role' => $validData['role']
            ];

            if (!empty($validData['mahasiswa'])) {
                $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa);
                $data['nama'] = $mahasiswa->nama_mahasiswa;
                $data['email'] = $mahasiswa->email;
                $data['username'] = $mahasiswa->npm;
                $data['npm'] = $validData['mahasiswa'];
                $data['is_active'] = $mahasiswa->is_active;
            } else {
                $data['nama'] = $validData['nama'];
                $data['email'] = $validData['email'];
                $data['username'] = $validData['username'];
                $data['kode_prodi'] = $validData['prodi'];
            }
            DB::beginTransaction();
            $user = User::create($data);
            DB::commit();
            return response()->json(['success' => 'Berhasil menambahkan pengguna', 'data' => $user], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => 'Gagal menambahkan pengguna : ' . $e->getMessage()], 500);
        }
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
    public function edit(User $user)
    {
        $loggedInUserId = auth()->user()->username;
        if ($user->username === $loggedInUserId || $user->role === 'super') {
            return abort(404);
        }
        $data['user'] = $user;
        if ($user->role === 'admin') $data['prodis'] = Prodi::select('kode_prodi', 'nama_prodi')->get();
        return view('super.users.form-user', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $rules = [
                'nama' => 'required|string|min:2|max:150',
                'username' => [
                    Rule::excludeIf($user->role === 'user'),
                    'required',
                    'string',
                    'min:5',
                    'max:100',
                    Rule::unique('users')->ignore($user->username, 'username'),
                    Rule::unique('mahasiswas', 'npm')
                ],
                'password' => 'nullable|string|min:8|max:150'
            ];

            if ($user->role === 'user') {
                $rules['email'] = [
                    'required', 'email',
                    Rule::unique('mahasiswas')->ignore($user->npm, 'npm'),
                    Rule::unique('users', 'email')->ignore($user->username, 'username')
                ];
            } else {
                $rules['email'] = [
                    'required', 'email',
                    Rule::unique('users')->ignore($user->username, 'username'),
                    Rule::unique('mahasiswas', 'email')
                ];
                $rules['prodi'] = 'required|string';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $validData = $validator->validated();
            $data = [
                'nama' => $validData['nama'],
                'email' => $validData['email']
            ];
            DB::beginTransaction();
            if ($user->role === 'user') {
                $user->mahasiswa()->update(['email' => $validData['email']]);
            } else {
                $data['username'] = $validData['username'];
                $data['kode_prodi'] = $validData['prodi'];
            }

            !empty($validData['password']) ?? ($data['password'] = $validData['password']);

            $user->update($data);
            DB::commit();
            return to_route('users.index')->with('success', 'Berhasil mengupdate data');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('failed', 'Gagal mengupdate data : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $loggedInUserId = auth()->user()->username;
            if ($user->username === $loggedInUserId || $user->role == 'super') {
                throw new \Exception('User Not Found!', 404);
            }
            $user->delete();
            return response()->json(['success' => 'Berhasil menghapus data'], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }
    }

    public function updateActiveStatus(Request $request)
    {
        try {
            $user = User::findOrFail(decryptString($request->id));
            $user->is_active = !$user->is_active;
            DB::beginTransaction();
            if ($user->role === 'user') {
                $user->mahasiswa()->update(['is_active' => !$user->mahasiswa->is_active]);
            }
            $user->save();
            DB::commit();
            return response()->json(['success' => 'Berhasil mengupdate data pengguna', 'updatedstatus' => $user->is_active], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }
}
