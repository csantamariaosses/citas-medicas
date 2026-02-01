<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BloodType;
use Illuminate\Support\Facades\DB;

class BloodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloodTypes = BloodType::all();
        //dd( $bloodTypes );
        return view('admin.bloodTypes.index', compact('bloodTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bloodTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bloodTypes = new BloodType();
        $bloodTypes->name = $request->input('name');
        $bloodTypes->save();

        session()->flash( 'swal' , [
            'title' => 'Tipo de Sangre creado',
            'text' => 'El tipo de sangre ha sido creado con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        return redirect()->route('bloodTypes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bloodType = BloodType::findOrFail($id);
        return view('admin.bloodTypes.show', compact('bloodType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bloodType = BloodType::findOrFail($id);
        return view('admin.bloodTypes.edit', compact('bloodType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bloodType = BloodType::findOrFail($id);
        $bloodType->name = $request->input('name');
        $bloodType->save();

        session()->flash( 'swal' , [
            'title' => 'Tipo de Sangre Actualizado',
            'text' => 'El tipo de sangre ha sido actualizado con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 


        return redirect()->route('bloodTypes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
