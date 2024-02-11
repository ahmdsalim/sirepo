<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        // Page Length
        $pageNumber = ( $request->start / $request->length )+1;
        $pageLength = $request->length;
        $skip       = ($pageNumber-1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // get data from users table
        $query = User::select('*');

        // Search
        $search = $request->search;
        $query = $query->where(function($query) use ($search) {
            $query->orWhere('username', 'like', "%".$search."%");
            $query->orWhere('nama', 'like', "%".$search."%");
            $query->orWhere('email', 'like', "%".$search."%");
            $query->orWhere('role', 'like', "%".$search."%");
        });


        $orderByName = 'username';
        switch($orderColumnIndex){
            case '0':
                $orderByName = 'username';
                break;
            case '1':
                $orderByName = 'nama';
                break;
            case '2':
                $orderByName = 'email';
                break;
            case '3':
                $orderByName = 'role';
                break;
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $users = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw"=> $request->draw, "recordsTotal"=> $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $users], 200);
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
