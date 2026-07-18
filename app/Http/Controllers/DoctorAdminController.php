<?php

namespace App\Http\Controllers;

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

class DoctorAdminController extends Controller
{
    public function index()
    {

         //dd( session('user_id') );    
         $doctor = Doctor::where('user_id', session('user_id'))
                           ->first();
         session(['doctor_id' => $doctor->id]);
         //dd( session('doctor_id') );

         $appointments = Appointment::where('doctor_id', session('doctor_id'))->orderBy('date', 'desc')->get();
         //dd( $citas->all() );
   
         $doctor = Doctor::find(session('doctor_id'));
         return view('doctor.index', compact('appointments','doctor'));
          
     
    }


    public function gestionar($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('doctor.gestionar', compact('appointment'));
    }

    public function update(Request $request )
    {
        //dd( $request->all() );
        $appointment = Appointment::findOrFail($request->cita_id );        
        $appointment->status = $request->input('status');
        $appointment->save();

        $patient = Patient::find($appointment->patient_id);
        $patient->allergies = $request->input('allergies');
        $patient->chronics_conditions = $request->input('chronicDiseases');
        $patient->save();


        $consult = Consultation::where('appointment_id', $request->cita_id)->first();
        if( $consult ){
            
            $consult->diagnostic = $request->diagnostic;
            $consult->treatment = $request->treatment;
            $consult->notes = $request->notes;
            $consult->prescriptions  = $request->prescriptions;
            $consult->save();
        }else{  
            $consulta = New Consultation();
            $consulta->appointment_id = $request->cita_id;
            $consulta->diagnostic = $request->diagnostic;
            $consulta->treatment = $request->treatment;
            $consulta->notes = $request->notes;
            $consulta->prescriptions  = $request->prescriptions;
            $consulta->save();
        }

        //dd( $appointment->all());

        return redirect()->route('doctor.index')->with('success', 'Cita actualizada correctamente.');
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
