<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * Show the reset password form.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm($token)
    {
        return view('auth.resetPassword', ['token' => $token]);
    }

    public function getPassword($token)
    {
        return $this->showResetForm($token);
    }

    /**
     * Handle the password reset process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        try {
            // Validate the request inputs
            $request->validate([
                'email'    => 'required|email|exists:users,email',
                'password' => 'required|string|min:6|confirmed',
                'token'    => 'required',
            ]);

            $resetTable = config('auth.passwords.users.table', 'password_reset_tokens');

            // Find password reset record
            $resetRecord = DB::table($resetTable)
                ->where('email', $request->email)
                ->first();

            if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
                return back()->with('error', 'Invalid token!')->withInput();
            }

            // Check if the token has expired
            if (Carbon::parse($resetRecord->created_at)->addMinutes(60)->isPast()) {
                return back()->with('error', 'The password reset link has expired.')->withInput();
            }

            // Find the user and update the password
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);

                DB::table($resetTable)->where('email', $request->email)->delete();

                return redirect()->route('login')->with('status', 'Your password has been changed successfully!');
            }

            return back()->with('error', 'User not found!')->withInput();

        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while updating your password. Please try again later.');
        }
    }

    public function updatePassword(Request $request)
    {
        return $this->reset($request);
    }
}
