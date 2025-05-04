<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);;
        if ($users->isEmpty()) {
            return response()->json([
                "message" => "data kosong"
            ], 200,);
        }
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->getData();
        $user = User::create($validated);
        return response()->json([
            "message" => "berhasil dibuat"
        ], 200,);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "message" => "data tidak ditemukan"
            ], 404,);
        }
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, $id)
    {
        $validated = $request->getData();
        $user = User::find($id);
        $user->update($validated);
        return response()->json([
            "message" => "berhasil diupdate"
        ], 200,);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "message" => "data tidak ditemukan"
            ], 404,);
        }
        $user->delete();
        return response()->json([
            "message" => "berhasil dihapus"
        ], 204,);
    }
}
