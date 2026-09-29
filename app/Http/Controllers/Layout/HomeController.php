<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
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
        return view('department');
    }
    public function doctor()
    {
        return view('doctors');
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
