<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class ApiUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HasApiTokens;

    public function index()
    {
        $data = [
            'message' => 'API funcionando correctamente'
        ];
        $usuarios = \App\Models\User::all();
        $data['datos'] = $usuarios;
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        if( \App\Models\User::destroy($id) ) {
            session()->flash( 'swal' , [
                'title' => 'Usuario eliminado',
                'text' => 'El usuario ha sido eliminado con exito',
                'icon' => 'success',
                //'timer' => 3000,
                'showConfirmButton' => false
            ]);

            return redirect()->route('users.index');

        } 

        

        $data = [
            'message' => 'ocurrio un error al eliminar el producto'
        ];

        return response()->json($data, 200);
    }

    public function login(Request $request) {
        
        $credentials = $request->only('email', 'password');
        if( Auth::attempt($credentials) ) {
            $user_id = Auth::id();
            $user = Auth::user();   

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json( [
                'access_token' => $token,
                'token_type' => 'Bearer'

            ], 200);
        } else {
            return response()->json( [
                'message' => 'Invalid Login'
            ], 401);
        }
    }

    public function infouser(Request $request ){
        $user = User::where('email', $request->input('email'))->first();
        return response()->json( [
            'id'   => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'address' => $user->address
        ], 200);
    
    }
}
