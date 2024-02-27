<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\UserModerationApproved;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('super.users.index');
    }

    public function getUsers(Request $request)
    {
        $users = User::approved()->exceptlogged()->latest()->get();
        return DataTables::of($users)
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="btn btn-primary btn-sm" href="' . route("users.edit", ["user" => $row->username]) . '">Edit</a>
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
            ->rawColumns(['action', 'created_at'])
            ->make(true);
    }

    public function indexApprove()
    {
        return view('super.approve.index');
    }

    public function getApproveUsers(Request $request)
    {
        $users = User::toapprove()->latest()->get();
        return DataTables::of($users)
            ->editColumn('verifikasi_file', function ($row) {
                $raw = '<a href="' . Storage::url('file-verifikasi/' . $row->verifikasi_file) . '" data-lightbox="' . $row->verifikasi_file . '" data-title="' . $row->username . '">' . $row->verifikasi_file . '</a>';
                return $raw;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<form class="d-inline-block" action="' . route('setApprovedUser') . '" method="POST">
                <input type="hidden" name="_token" value="' . csrf_token() . '" autocomplete="off">
                <input type="hidden" name="id" value="' . $row->hash_username . '" autocomplete="off">
                <button type="button" class="btn btn-success btn-sm approve-button" id="btnApprove">Approve</button>
                </form>
                <button type="button" class="btn btn-danger text-white btn-sm reject-button" data-id="' . encryptString($row->username) . '" id="btnReject">
                    Reject
                </button>';
                return $actionBtn;
            })
            ->rawColumns(['verifikasi_file', 'action'])
            ->make(true);
    }

    public function setApprovedUser(Request $request)
    {
        try {
            $user = User::findOrFail(decryptString($request->id));
            $destination = 'public/file-verifikasi/';
            Storage::delete($destination . $user->verifikasi_file);
            $user->verifikasi_file = '';
            $user->terverifikasi = true;
            $user->save();
            event(new UserModerationApproved($user));
            return back()->with('success', 'Berhasil mengapprove user');
            // return response()->json(['success' => 'Berhasil mengapprove user', 'data' => ['id' => $user->hash_username]], 200);
        } catch (\Exception $e) {
            return back()->with('failed', 'Error : ' . $e->getMessage());
            // return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    private function sendEmailApproved(Request $request)
    {
        try {
            $username = decryptString($request->id);
            $user = User::findOrFail($username);
            event(new UserModerationApproved($user));
            return response()->json(['success' => 'Berhasil mengirimkan email']);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function setRejectedUser(Request $request)
    {
        try {
            $user = User::findOrFail(decryptString($request->username));
            $destination = 'public/file-verifikasi/';
            Storage::delete($destination . $user->verifikasi_file);
            $user->delete();
            return response()->json(['success' => 'Berhasil menolak dan menghapus data user', 'data' => ['username' => $request->username]], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }
    }

    public function profile()
    {
        $user = auth()->user();
        return view('akun.profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($user->username, 'username')
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $user->nama = $data['nama'];
        $user->email = $data['email'];
        $user->save();

        return response()->json(['success' => 'Berhasil mengupdate profile', 'data' => ['nama' => $data['nama']]]);
    }

    public function security()
    {
        return view('akun.keamanan.index');
    }

    public function securityUpdate(Request $request)
    {
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|min:5|max:100|unique:users,username',
            'password' => 'required|string|min:8|max:150',
            'role' => 'required|in:super,admin,user'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validData = $validator->validated();
        $user = User::create([
            'nama' => $validData['nama'],
            'email' => $validData['email'],
            'username' => $validData['username'],
            'password' => $validData['password'],
            'terverifikasi' => true,
            'role' => $validData['role'],
        ]);

        return response()->json(['success' => 'Berhasil menambahkan pengguna', 'data' => $user], 200);
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
        return view('super.users.form-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'email' => [
                'required', 'email',
                Rule::unique('users')->ignore($user->username, 'username')
            ],
            'username' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('users')->ignore($user->username, 'username')
            ],
            'password' => 'nullable|string|min:8|max:150',
            'role' => 'required|in:super,admin,user'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validData = $validator->validated();
        $data = [
            'nama' => $validData['nama'],
            'email' => $validData['email'],
            'username' => $validData['username'],
            'role' => $validData['role'],
        ];

        !empty($validData['password']) ?? ($data['password'] = $validData['password']);

        $user->update($data);

        return to_route('users.index')->with('success', 'Berhasil mengupdate data');
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
}
