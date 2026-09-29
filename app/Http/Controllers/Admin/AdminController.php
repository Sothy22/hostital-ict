<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $users =User::all();
        return response()->json([
            'data' => $users,
            'message' => "Users Retrieved Successfully"
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email",
            "password" => "required|string|min:8|confirmed",
            "image" => "nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048",
            "role" => "required|string|in:doctor,pharmacy,accountant,receptionist",
            "permissions" => "required|string",
            // "permissions.*" => "string",
        ]);

        $permissions = json_decode($request->permissions, true);

        if (!is_array($permissions)) {
            return response()->json([
                "message" => "Permissions must be an array."
            ], 422);
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "image" => $imagePath,
            "role" => $request->role,
            "permissions" => $permissions,
        ]);

        return response()->json([
            "data" => $user,
            "message" => "User Created Successfully"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => "User Not Found"
            ], 404);
        }

        $request->validate([
            "name" => "sometimes|required|string|max:255",
            "email" => "sometimes|required|string|email|max:255|unique:users,email," . $user->id,
            "password" => "sometimes|required|string|min:8|confirmed",
            "role" => "sometimes|required|string|in:doctor,pharmacy,accountant,receptionist",
            "image" => "nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048",
            "permissions" => "sometimes|required|array",
            "permissions.*" => "string",
        ]);

        $user->update($request->all());

        return response()->json([
            'data' => $user,
            'message' => "User Updated Successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->image) {
            $oldPath = str_replace('/storage', '', $user->image);
            Storage::disk('public')->delete($oldPath);
        }

        $user->delete();

        return response()->json([
            'message' => "User Deleted Successfully"
        ], 200);
    }
}
