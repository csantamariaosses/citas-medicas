<?php

namespace App\Http\Controllers;

session_start();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('autho.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if( Auth::attempt($credentials) ) {
            // Authentication passed...
            $request->session()->regenerate(); 
            session(['user_id' => Auth::id()]);
            session('user_name', Auth::user()->name);
            session('user_email', Auth::user()->email);
            //  dd( session()->all() );
            if( Auth::user()->name === 'Admin' ) {
                return redirect()->route('admin.index');
            } else {
                return redirect()->route('dashboard');
            }

        }   
        return back()->withErrors([
            'email' => 'Credenciales incorrectas.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return view('autho.register');
    }   

}
