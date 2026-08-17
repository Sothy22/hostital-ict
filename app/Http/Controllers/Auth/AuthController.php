<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // if (!$user) {
        //     return response()->json([
        //         "message" => "Email or password is incorrect"
        //     ], 401);
        // }

        // if (!Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'message' => 'Email or password is incorrect',
        //     ], 401);
        // }
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect',
            ], 401);
        }

        $token = $user->createToken('hospital-api-token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
}
