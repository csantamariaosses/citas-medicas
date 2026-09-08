<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Speciality;
use Spatie\Permission\Models\Role;  
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
//use Spatie\LaravelPdf\Facades\Pdf;

class AdminDoctorController extends Controller
{
    public function index()
    {

        //dd("AdminDoctorController");
         $doctor = Doctor::where('user_id', session('user_id'))
                           ->first();
         $appointments = Appointment::where('doctor_id', session('doctor_id'))->orderBy('date', 'desc')->get();
         $doctor = Doctor::find(session('doctor_id'));
         $doctores = Doctor::orderBy('created_at', 'desc')->get();
         $specialities = Speciality::all();
         $roles = Role::all();
         return view('admin.doctores.index', compact('appointments','doctores', 'specialities','doctor', 'roles'));
          
     
    }


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

        $doctores = Doctor::orderBy('created_at', 'desc')->get();
        $roles = Role::all();

        return redirect()->route('doctores.index', compact('doctores', 'roles'));
    }


    public function gestionar($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('doctor.gestionar', compact('appointment'));
    }

    public function update(Request $request )
    {
        //dd("doctores.admin.update");
        //dd( $request->all() );
        $doctor_id =$request->input('id');
        $user_id = Doctor::where('id', $doctor_id)->pluck('user_id')->first();

        //dd( $doctor_id, $user_id );

        $user = User::findOrFail($user_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->save();

        $doctor = Doctor::findOrFail($doctor_id);
        $doctor->speciality_id = $request->input('speciality');
        $doctor->medical_license_number = $request->input('medical_license_number');
        $doctor->active = $request->input('active');
        $doctor->save();

        //dd( $appointment->all());

        return redirect()->route('doctores.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function dashboard()
    {
        $doctor = Doctor::where('user_id', session('user_id'))->first();
        $appointments = Appointment::where('doctor_id', $doctor->id)->orderBy('date', 'desc')->get();
        return view('doctor.dashboard', compact('appointments','doctor'));
    }


    public function consultaPdf($id)
    {


        $appointment = Appointment::findOrFail($id);
        $patient_id = $appointment->patient_id;
        $patient = Patient::find($patient_id);
        $nombrePaciente = $patient->user->name;
        
        $fecha = substr($appointment->date, 0, 10);
        $hora =  substr($appointment->start_time, 11, 10);


        $doctor_id = $appointment->doctor_id;
        $doctor = Doctor::find($doctor_id);
        $nombreDoctor = $doctor->user->name;

        $consulta = Consultation::where('appointment_id', $id)->first();
        $diagnostic = $consulta ? $consulta->diagnostic : '';
        $treatment = $consulta ? $consulta->treatment : '';
        $notes = $consulta ? $consulta->notes : '';
        $prescriptions = $consulta ? $consulta->prescriptions : '';


        $data = [
            'citaId' => $id,   // id appointment
            'fecha' => $fecha,
            'hora' => $hora,
            'doctorName' => $nombreDoctor,
            'patientName' => $nombrePaciente,
            'diagnostic' => $diagnostic,
            'treatment' => $treatment,
            'notes' => $notes,
            'prescriptions' => $prescriptions
        ];

        //dd($data);
        //Pdf::view('doctor.consulta', $data )
        //    ->save('/publicconsulta.pdf');


        $pdf = Pdf::loadView('doctor/consulta', $data);

        // Opción 1: Descargar el archivo automáticamente
        //return $pdf->download('factura.pdf');

        // Opción 2: Visualizar en el navegador
        return $pdf->stream('factura.pdf');

    }

   
}
