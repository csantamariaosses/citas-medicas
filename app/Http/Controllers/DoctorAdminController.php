<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Speciality;
use Spatie\Permission\Models\Role;  
use App\Models\Appointment;
use App\Models\Consultation;

class DoctorAdminController extends Controller
{
    public function index()
    {

         //dd( session('user_id') );    
         $doctor = Doctor::where('user_id', session('user_id'))
                           ->first();
         session(['doctor_id' => $doctor->id]);
         //dd( session('doctor_id') );

         $citas = Appointment::where('doctor_id', session('doctor_id'))->orderBy('date', 'desc')->get();
   
         $doctor = Doctor::find(session('doctor_id'));
         return view('doctor.index', compact('citas','doctor'));
          
     
    }


    public function gestionar($id)
    {
        $cita = Appointment::findOrFail($id);
        return view('doctor.gestionar', compact('cita'));
    }

    public function update(Request $request )
    {
        //dd( $request->all() );
        $cita = Appointment::findOrFail($request->cita_id );
        $cita->status = $request->input('status');
        $cita->save();

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

        return redirect()->route('doctor.index')->with('success', 'Cita actualizada correctamente.');
    }
}
