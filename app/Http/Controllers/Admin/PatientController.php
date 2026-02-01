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

    
    /*
        $patients = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('blood_types', 'patients.blood_type_id', '=', 'blood_types.id')
            ->select('patients.id as id', 'patients.allergies', 'patients.chronics_conditions',
            'patients.observations', 'patients.emergency_contact_name',
            'patients.user_id', 'users.name', 'users.email', 'users.address','users.phone',
            'blood_types.name as blood_type')
            ->get();
            //dd($patients);
*/
        $patients = Patient::all();
        //dd( $patients );
        return view('admin.patients.index', compact('patients'));
    }   

    public function create()
    {
        $bloodType = BloodType::all();
        $role = Role::all();
        return view('admin.patients.create', compact('bloodType', 'role'  ));
    }

    public function store(Request $request)
    {
        //return "Store Patient";
        
        $user = new User();
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
        
        /*
        $patients = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('blood_types', 'patients.blood_type_id', '=', 'blood_types.id')
            ->select('patients.id as id', 'patients.allergies', 'patients.chronics_conditions',
            'patients.observations', 'patients.emergency_contact_name',
            'patients.user_id', 'users.name', 'users.email', 'users.address','users.phone',
            'blood_types.name as blood_type')
            ->get();
        */
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));

    }   

    public function show(string $id)
    {
        /*
        $patient = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('blood_types', 'patients.blood_type_id', '=', 'blood_types.id')
            ->where('patients.id', $id)
            ->select('patients.id as id', 'patients.allergies', 'patients.chronics_conditions',
            'patients.observations', 'patients.emergency_contact_name',
            'patients.user_id', 'users.name', 'users.email', 'users.address','users.phone',
            'blood_types.name as blood_type')
            ->get()->first();
            //dd($patient->name);
            */
        $patient = Patient::findOrFail( $id );
        return view('admin.patients.show', compact('patient'));
 
    }   

    public function edit(string $id)
    {
        //
         $bloodType = BloodType::all();
         /*
         $patient = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('blood_types', 'patients.blood_type_id', '=', 'blood_types.id')
            ->where('patients.id', $id)
            ->select('patients.id as id', 'patients.allergies', 'patients.chronics_conditions',
            'patients.observations', 'patients.emergency_contact_name',
            'patients.user_id', 'users.name', 'users.email', 'users.address','users.phone',
            'blood_types.name as blood_type')
            ->get()->first();
            */
        $patient = Patient::findOrFail( $id );
        return view('admin.patients.edit', compact('patient', 'bloodType'));
 
    }       

    public function update(Request $request, string $id)
    {
        //
        //dd($request->all());
        // Tabla Patients
        // Typo de Sangre
        // Alergias
        // Condiciones Cronicas
        // Observaciones
        // Contacto de Emergencia

        // Tabla Users
        // Nombre
        // Email
        // Direccion
        // Telefono
        // Password
        $patient = Patient::findOrFail( $id );
        $user = User::findOrFail( $patient->user_id );
        
        $patient->blood_type_id = $request->input('bloodType');
        $patient->allergies = $request->input('allergies');
        $patient->chronics_conditions = $request->input('chronics_conditions');    
        $patient->observations = $request->input('observations');
        $patient->emergency_contact_name = $request->input('emergency_contact_name');
        $patient->save();
        

        //dd( $user);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        /*
        if( $request->input('password') != null && strlen( $request->input('password') ) > 0 ){
            $user->password = bcrypt( $request->input('password') );
        }
            */
        $user->save();

        /*
         $patients = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->join('blood_types', 'patients.blood_type_id', '=', 'blood_types.id')
            ->select('patients.id as id', 'patients.allergies', 'patients.chronics_conditions',
            'patients.observations', 'patients.emergency_contact_name',
            'patients.user_id', 'users.name', 'users.email', 'users.address','users.phone',
            'blood_types.name as blood_type')
            ->get();
*/
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));


        //return "Update Patient";
    }   

    public function destroy(string $id)
    {
        //
        return "Destroy Patient";
    }   

}
