<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
