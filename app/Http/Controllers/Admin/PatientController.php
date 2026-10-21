<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\BloodType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class PatientController extends Controller
{
    //
    public function index()
    {
        $patients = Patient::orderBy('created_at', 'desc')->get();
        $bloodType = BloodType::all();
        $roles = Role::all();

        return view('admin.patients.index', compact('patients', 'bloodType', 'roles'));
    }   

    public function create()
    {
        $bloodType = BloodType::all();
        $role = Role::all();
        return view('admin.patients.create', compact('bloodType', 'role'  ));
    }

    public function store(Request $request)
    {

        //dd( $request->all());
        $email = $request->input('email');
        $email_ = User::where('email', $email)->get();
        //dd( $email_);
        if( count(  $email_ )=== 0 ) {
            //dd("crear paciente");
            $user = new User();
            $user->rut = $request->input('rut');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone = $request->input('phone');
                    
            $user->password = bcrypt($request->input('password'));
            $user->save();
            $user->assignRole('Paciente');

            $userId = $user->id;

            $patient = new Patient();
            $patient->user_id = $userId;

            $patient->birth_date = $request->input('birth_date');
            $patient->gender = $request->input('gender');
            $patient->blood_type_id = $request->input('bloodType');
            $patient->allergies = $request->input('allergies');

            $patient->chronics_conditions = $request->input('chronics_conditions');    
            $patient->observations = $request->input('observations');
            $patient->emergency_contact_name = $request->input('emergency_contact_name');

            $patient->save();

            
            session()->flash( 'swal' , [
                'title' => 'Paciente creado',
                'text' => 'El paciente ha sido creado con exito !!!!',
                'icon' => 'success',
                //'timer' => 3000,
                'showConfirmButton' => 'Ok'
            ]); 
            
            $patients = Patient::orderBy('created_at', 'desc')->get();
            $bloodType = BloodType::all();
            $roles = Role::all();
            return view('admin.patients.index', compact('patients', 'bloodType', 'roles'));
        } else {
            /*
            session()->flash( 'swal' , [
                'title' => 'Paciente creado',
                'text' => 'El paciente ha sido creado con exito !!!!',
                'icon' => 'success',
                //'timer' => 3000,
                'showConfirmButton' => 'Ok'
            ]); 
            */
            //dd("ya creado");
            $patients = Patient::orderBy('created_at', 'desc')->get();
            $bloodType = BloodType::all();
            $roles = Role::all();
            return view('admin.patients.index', compact('patients', 'bloodType', 'roles'));
        }
        
        

    }   

    public function show(string $id)
    {
        
        $patient = Patient::findOrFail( $id );
        return view('admin.patients.show', compact('patient'));
 
    }   

    public function edit(string $id)
    {
        //
        $bloodType = BloodType::all();         
        $patient = Patient::findOrFail( $id );
        return view('admin.patients.edit', compact('patient', 'bloodType'));
 
    }       

    public function update(Request $request, string $id)
    {
        //dd( $request->all() );
        $patient = Patient::findOrFail( $id );
        $user = User::findOrFail( $patient->user_id );
        
        $patient->birth_date = $request->input('birth_date');
       
        $patient->gender = $request->input('gender');
        $patient->blood_type_id = $request->input('bloodType');
        $patient->allergies = $request->input('allergies');
        $patient->chronics_conditions = $request->input('chronics_conditions');    
        $patient->observations = $request->input('observations');
        $patient->emergency_contact_name = $request->input('emergency_contact_name');
        $patient->save();
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
       
        $user->save();

        $patients = Patient::all();
        $bloodType = BloodType::all();
        $roles = Role::all();

        return view('admin.patients.index', compact('patients', 'bloodType', 'roles'));


        //return "Update Patient";
    }   

    public function destroy(string $id)
    {
        //
        return "Destroy Patient";
    }   

}
