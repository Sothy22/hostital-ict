<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'Login successful.',
                'token' => $admin->createToken('admin-api-token')->plainTextToken,
                'user' => $admin,
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect.',
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful.',
            'token' => $user->createToken('api-token')->plainTextToken,
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);

            $request->session()->regenerate();

            return redirect()->route('main_admin');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'Email or password is incorrect.',
                ])
                ->withInput();
        }

        Auth::guard('web')->login($user);

        $request->session()->regenerate();

        if ($user->role === 'doctor') {
            return redirect()->route('main_doctor');
        }

        Auth::guard('web')->logout();

        return redirect()->route('login')
            ->withErrors([
            'email' => 'You do not have permission to access this system.',
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();

        // $request->session()->regenerateToken(); // for page in web

        // return redirect()->route('login');

        return response()->json([
            'message' => 'Logout Successfully'
        ], 200);
    }

    public function apiLogout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logout Successfully'
        ], 200);
    }
}
