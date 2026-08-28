<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Storage;


class UserController extends Controller
{
    // public function index(){
    //     $users =User::all();
    //     return response()->json([
    //         'data' => $users,
    //         'message' => "Users Retrieved Successfully"
    //     ],200);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         "name" => "required|string|max:255",
    //         "email" => "required|string|email|max:255|unique:users,email",
    //         "password" => "required|string|min:8|confirmed",
    //         "image" => "nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048",
    //         "role" => "required|string|in:doctor,pharmacy,account,reception",
    //         "permissions" => "required|string",
    //         // "permissions.*" => "string",
    //     ]);

    //     $permissions = json_decode($request->permissions, true);

    //     if (!is_array($permissions)) {
    //         return response()->json([
    //             "message" => "Permissions must be an array."
    //         ], 422);
    //     }

    //     $imagePath = null;

    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('users', 'public');
    //     }

    //     $user = User::create([
    //         "name" => $request->name,
    //         "email" => $request->email,
    //         "password" => $request->password,
    //         "image" => $imagePath,
    //         "role" => $request->role,
    //         "permissions" => $permissions,
    //     ]);

    //     return response()->json([
    //         "data" => $user,
    //         "message" => "User Created Successfully"
    //     ], 201);
    // }

    // public function show($id)
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json([
    //             'message' => "User Not Found"
    //         ], 404);
    //     }

    //     return response()->json([
    //         'data' => $user,
    //         'message' => "User Retrieved Successfully"
    //     ], 200);
    // }

    // public function update(Request $request, $id)
    // {
    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json([
    //             'message' => "User Not Found"
    //         ], 404);
    //     }

    //     $request->validate([
    //         "name" => "sometimes|required|string|max:255",
    //         "email" => "sometimes|required|string|email|max:255|unique:users,email," . $user->id,
    //         "password" => "sometimes|required|string|min:8|confirmed",
    //         "role" => "sometimes|required|string|in:doctor,pharmacy,account,reception",
    //         "permissions" => "sometimes|required|array",
    //         "permissions.*" => "string",
    //     ]);

    //     $user->update($request->all());

    //     return response()->json([
    //         'data' => $user,
    //         'message' => "User Updated Successfully"
    //     ], 200);
    // }

    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);

    //     if ($user->role === 'admin') {
    //         return response()->json([
    //             'message' => "Admin users cannot be deleted."
    //         ], 403);
    //     }

    //     if ($user->image) {
    //         $oldPath = str_replace('/storage', '', $user->image);
    //         Storage::disk('public')->delete($oldPath);
    //     }

    //     $user->delete();

    //     return response()->json([
    //         'message' => "User Deleted Successfully"
    //     ], 200);
    // }





}
