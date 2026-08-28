<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors([
                    'email' => 'Email or password is incorrect.',
                ])
                ->withInput();
        }

        Auth::login($user);

        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin');
        }

        if ($user->role === 'doctor') {
            return redirect()->route('doctor');
        }

        Auth::logout();

        return redirect()->route('login')
            ->withErrors([
            'email' => 'You do not have permission to access this system.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');

        // return response()->json([
        //     'message' => 'Logout Successfully'
        // ], 200);
    }
}
