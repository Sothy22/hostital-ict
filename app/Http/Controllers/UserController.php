<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(){
        $users =User::all();
        return response()->json([
            'data' => $users,
            'message' => "Users Retrieved Successfully"
        ],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:8|confirmed",
            "role" => "required|string|in:admin,doctor,accountant,receptionist,pharmacy"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "role" => $request->role
        ]);

        return response()->json([
            'data' => $user,
            'message' => "User Created Successfully"
        ], 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => "User Not Found"
            ], 404);
        }

        return response()->json([
            'data' => $user,
            'message' => "User Retrieved Successfully"
        ], 200);
    }
}
