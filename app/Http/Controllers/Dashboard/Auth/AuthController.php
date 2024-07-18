<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember_me');

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect()->route('dashboard.home.index');
        }

        Alert::error('Error', 'يوجد خطأ في البيانات المدخلة');
        return back();
    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard.login.index');
    }

}
