<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd( $request->name);

        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]); 
        $permission = New Permission();
        $permission->name = $request->input('name');
        $permission->save();

    
        session()->flash( 'swal' , [
            'title' => 'Permiso creado',
            'text' => 'El permiso ha sido creado con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions')) ;
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $permission = Permission::findById($id);
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $permission = Permission::findById($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$id,
        ]);
        $permission = Permission::findById($id);
        $permission->name = $request->name;
        $permission->save();

        session()->flash( 'swal' , [
            'title' => 'Permiso actualizado',
            'text' => 'El permiso ha sido actualizado con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));

    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $permission = Permission::findById($id);
        $permission->delete();
        session()->flash( 'swal' , [
            'title' => 'Permiso eliminado',
            'text' => 'El permiso ha sido eliminado con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
