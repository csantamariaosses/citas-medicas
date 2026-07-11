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
        //
        return view('autho.login');
    }

    public function login(Request $request)
    {

        //dd( $request->all() );

        $credentials = $request->only('email', 'password');
        if( Auth::attempt($credentials) ) {
            // Authentication passed...
            $user_id = Auth::id();
            $user = Auth::user();   
            //$user = User::find( $user_id );
            $request->session()->regenerate(); 
                      
            if ($user->hasRole('admin')) {
                session(['role' => 'admin']);
                return redirect()->route('admin.index');

            }
            if ($user->hasRole('paciente')) {
                session(['user_id' => Auth::id()]);
                session(['user_name' => Auth::user()->name]);
                session(['user_email' => Auth::user()->email]);
                session(['patientName' => Auth::user()->name]);
                session(['patient_id' => Auth::user()->patient->id]);
                session(['role' => 'paciente']);
                  
                return redirect()->route('horasmedicas.index');
                //dd("Autenticado - Es paciente");
            }
            if ($user->hasRole('doctor')) {
                session(['user_id' => $user_id ]);
                session(['user_name' => Auth::user()->name]);
                session(['user_email' => Auth::user()->email]);
                session(['doctorName' => Auth::user()->name]);
                session(['role' => 'doctor']);


                return redirect()->route('doctor.index');
                //dd("Autenticado - Es doctor");
            }

            
            session(['user_id' => Auth::id()]);
            session(['user_name' => Auth::user()->name]);
            session(['user_email' => Auth::user()->email]);
            session(['patientName' => Auth::user()->name]);
            


        }   else {
            //dd("No autenticado");
            return redirect()->back()->withErrors(['email' => 'Credenciales incorrectas.']);
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

        if ($request->isMethod('get')) {
            return view('autho.register');
        }

    }   

}
