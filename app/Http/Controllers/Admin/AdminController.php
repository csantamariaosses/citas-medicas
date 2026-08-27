<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function index() {
        return view('admin.index');
    }


    public function changePassword()
    {
        return view('admin.change-password');
    }

    public function changePasswordSave(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $id = Auth::id();
        $user = Auth::user();
        //dd( $id );
        /*
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }
            */

        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->route('change-password-ok')->with('success', 'Contraseña cambiada exitosamente.');
        
    }

    public function changePasswordOk()
    {
        return view('admin.change-password-ok');
    }
}
