<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $nameParts = preg_split('/\s+/', trim($validated['name']), 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $user = User::create([
            'name' => $validated['name'],
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $validated['gender'] === 'Other' ? 'Female' : $validated['gender'],
            'email' => $validated['email'],
            'mobile' => $validated['phone'],
            'address' => $validated['address'] ?? '',
            'nic' => '',
            'date_of_birth' => $validated['date_of_birth'],
            'status' => 'Active',
            'password' => Hash::make($validated['password']),
            'role' => 'patient',
            'permissions' => [],
        ]);

        Patient::create([
            'full_name' => $validated['name'],
            'dob' => $validated['date_of_birth'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? '',
            'user_id' => $user->_id,
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        $intendedUrl = $request->session()->pull('url.intended');
        return redirect()->to($intendedUrl ?: route('home'))
            ->with('success', 'Your patient account has been created successfully.');
    }

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

        if ($user->role === 'patient') {
            $intendedUrl = $request->session()->pull('url.intended');
            return redirect()->to($intendedUrl ?: route('home'));
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

        $request->session()->regenerateToken(); // for page in web

        return redirect()->route('login');

        // return response()->json([
        //     'message' => 'Logout Successfully'
        // ], 200);
    }

    public function apiLogout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logout Successfully'
        ], 200);
    }
}
