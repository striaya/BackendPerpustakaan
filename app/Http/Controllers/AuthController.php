<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($request->username == 'admin' && $request->password == 'admin123') {
            Session::put('login', true);
            Session::put('username', $request->username);
            Session::put('role', 'admin');
            return redirect('/')->with('success', 'Login berhasil!');
        }
        return back()->with('error', 'Username atau password salah!');
    }
    public function logout()
    {
        Session::flush();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
