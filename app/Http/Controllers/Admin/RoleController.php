<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
//use SweetAlert2\Laravel\Swal;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.roles.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd( $request->name );

        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        session()->flash( 'swal' , [
            'title' => 'Rol creado',
            'text' => 'El rol ha sido creado con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 
        
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $role = Role::findOrFail($id);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

    
        // Alerta lanzada desde el controlador
        // use SweetAlert2\Laravel\Swal;
        /*
        Swal::fire([
            'title' => 'Rol actualizado',
            'text' => 'El rol ha sido actualizado con exito Swal',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 
        */

        // Alerta lanzada desde ell controlador usando session
        session()->flash( 'swal' , [
            'title' => 'Rol Actualizado',
            'text' => 'El rol ha sido actualizado con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 


        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return "Roles destroy ".$id;
    }
}
