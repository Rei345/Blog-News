<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect()->intended('/admin');
        } else {
            return redirect(route('auth.index'))->with('pesan', ['danger', 'Kombinasi email dan password salah ']);
        }
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Membuat pengguna dengan role viewer
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'viewer',
        ]);

        return redirect()->route('auth.index')->with('pesan', ['success', 'Akun berhasil dibuat. Silahkan login!']);
    }

    public function logout()
    {
        if (Auth::guard('user')->check())
        {
            Auth::guard('user')->logout();
        }
        return redirect(route('auth.index'));
    }
}
