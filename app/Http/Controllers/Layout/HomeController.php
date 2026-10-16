<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('index');
    }
    public function appointment_page()
    {
        return view('appointment_page');
    }
    public function about()
    {
        return view('about_us');
    }
   public function contact()
    {
        return view('contact');
    }
    public function contact_us()
    {
        return view('contact_us');
    }
    public function department()
    {
        $departments = User::with('department')->where('role', 'department_head')->get();

        return view('department', compact('departments'));
    }
    public function doctor()
    {
        $doctors = User::with('department')->where('role', 'doctor')->get();

        return view('doctors', compact('doctors'));
    }
    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        return back()->with(
            'success',
            'Your message has been sent successfully!'
        );
    }
}
