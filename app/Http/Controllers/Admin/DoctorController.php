<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Speciality;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $doctores = Doctor::all();
        //dd( $doctores );
        $roles = Role::all();
        return view('admin.doctores.index', compact('doctores', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $specialities = Speciality::all();
        $roles = Role::all();
        return view('admin.doctores.create', compact('specialities', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd( $request->all() );
        //dd($request->input('role')->name());
        $user = new User();
        //Asignar valores al modelo $user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password = bcrypt('password'); // Contraseña por defecto
        $user->save();
        $roleName = Role::find($request->input('role'))->name;
        //dd( $roleName );
        $user->assignRole($roleName);

        $doctor = new Doctor();
        //Asignar valores al modelo $doctor
        $doctor->user_id = $user->id;
        $doctor->speciality_id = $request->speciality;
        $doctor->medical_license_number = $request->medical_license_number;
        $doctor->biography = $request->biography;

        $doctor->save();

        $doctores = Doctor::all();
        $roles = Role::all();

        return redirect()->route('doctores.index', compact('doctores', 'roles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
        return view('admin.doctores.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id )
    {
        //
        $doctor = Doctor::findOrFail( $id );
        $roles = Role::all();
        $specialities = Speciality::all();

        return view('admin.doctores.edit', compact('doctor', 'id', 'specialities', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,id',
            'speciality' => 'required|exists:specialities,id',
            'medical_license_number' => 'nullable|string|max:100',
            'biography' => 'nullable|string',
        ]);

        //dd(Role::find($request->input('role'))->name);
        // Info Doctor
        $doctor = Doctor::findOrFail( $id );
        $doctor->speciality_id = $request->speciality;
        $doctor->medical_license_number = ($request->medical_license_number? $request->medical_license_number : '' );
        $doctor->biography = $request->biography;
        $doctor->active = $request->active ? true : false;  
        $doctor->save();

        // Info User
        $user = User::findOrFail( $doctor->user_id );
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $roleName = Role::find($request->input('role'))->name;
        $user->syncRoles($roleName);
        $user->save();
        
        $doctores = Doctor::all();
        return view('admin.doctores.index', compact('doctores'));
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
        return redirect()->route('doctores.index');
    }

    public function schedules( $id )
    {
        //
        $doctor = Doctor::findOrFail( $id );
        return view('admin.doctores.schedule', compact('doctor'));
    }   
}
