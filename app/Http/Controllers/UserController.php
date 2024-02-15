<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function getUsers(Request $request) {
        $users = User::latest()->get();
            return DataTables::of($users)
            ->addColumn('action', function($row) {
                $actionBtn = '<a class="btn btn-primary btn-sm" href="'.route("users.edit",["user"=>$row->username]).'">Edit</a>
                <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="'.$row->username.'" id="btnDelete">
                    Hapus
                </button>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function indexApprove() {
        return view('super.approve.index');
    }

    public function getApproveUsers(Request $request) {
        $users = User::toapprove()->latest()->get();
            return DataTables::of($users)
            ->editColumn('verifikasi_file', function($row){
                $raw = '<a href="'.Storage::url('file-verifikasi/'.$row->verifikasi_file).'" data-lightbox="'.$row->verifikasi_file.'" data-title="'.$row->username.'">'.$row->verifikasi_file.'</a>';
                return $raw;
            })
            ->addColumn('action', function($row) {
                $actionBtn = '<button class="btn btn-success btn-sm approve-button" data-id="'.$row->username.'" id="btnApprove">Approve</button>
                <button type="button" class="btn btn-danger text-white btn-sm reject-button" data-id="'.$row->username.'" id="btnReject">
                    Reject
                </button>';
                return $actionBtn;
            })
            ->rawColumns(['verifikasi_file','action'])
            ->make(true);
    }

    public function setApprovedUser(Request $request) {
        try {
            $user = User::findOrFail($request->username);
            $destination = 'public/file-verifikasi/';
            Storage::delete($destination . $user->verifikasi_file);
            $user->verifikasi_file = '';
            $user->terverifikasi = true;
            $user->save();
            return response()->json(['success' => 'Berhasil mengapprove user','data' => ['username' => $request->username]],200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()],500);
        }
    }

    public function setRejectedUser(Request $request) {
        try {
            $user = User::findOrFail($request->username);
            $destination = 'public/file-verifikasi/';
            Storage::delete($destination . $user->verifikasi_file);
            $user->delete();
            return response()->json(['success' => 'Berhasil menolak dan menghapus data user','data' => ['username' => $request->username]],200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()],500);
        }
    }

    public function profile() {
        $user = auth()->user();
        return view('akun.profile.index', compact('user'));
    }
    
    public function updateProfile(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:2|max:150',
            'email' => [
                'required','email',
                Rule::unique('users')->ignore($user->username, 'username')
            ]
        ]);

        if($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()],422);
        }
        $data = $validator->validated();
        $user->nama = $data['nama'];
        $user->email = $data['email'];
        $user->save();
        
        return response()->json(['success' => 'Berhasil mengupdate profile','data'=> ['nama' => $data['nama']]]);
    }

    public function security() {
        return view('akun.keamanan.index');
    }
    
    public function securityUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password_confirmation' => 'required',
            'password' => 'required|confirmed|min:8|different:current_password',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()],422);
        }
        $data = $validator->validated();
        $user = Auth::user();
        if(Hash::check($data['current_password'], $user->password)){
            $user->fill([
                'password' => Hash::make($data['password'])
            ])->save();
            
            return response()->json(['success' => 'Berhasil mengupdate password']);
        }
        return response()->json(['errors' => ['current_password' => [
            "Password does not match"
        ]]],422);
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

        if($validator->fails()) {
            return response()->json(['errors'=> $validator->errors()],422);
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

        return response()->json(['success' => 'Berhasil menambahkan pengguna','data'=>$user],200);
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
                'required','email',
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

        if($validator->fails()) {
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
        try{
            $user->delete();
            return response()->json(['success' => 'Berhasil menghapus data'],200);
        }catch(\Exception $e) {
            return response()->json(['errors' => $e->getMessage()],422);
        }
    }
}