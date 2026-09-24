<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use DateTime;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Speciality;

class PatientController extends Controller
{
    //
     public function index()
    {
        $user_id = session('user_id');

        $user = User::find($user_id);        
        $patient_id = $user->patient->id;

        $appointments = Appointment::where('patient_id', $patient_id)->orderBy('date','desc')->get();
        $especialidades = Speciality::all();
        $doctors = Doctor::all();
        // dd(  $patient_id );
        return view("horasmedicas.index", compact('especialidades','doctors', 'appointments') );    

    }

    public function showcalendar(Request $request)
    {
        //dd($request->all());
        session(['doctor_id' =>  $request->doctor_id + 0]);
        $doctor = Doctor::findOrfail( $request->doctor_id);
        $doctorName = $doctor->user->name;
        session(['doctorName' =>  $doctorName]);
        //dd( $doctorName);

        //dd("Patient ShowCalendar");
        //dd( session('user_id'), session('doctor_id'));


        $user_id = session('user_id');
        $user = User::find($user_id);        
        $patient_id = $user->patient->id;


        $speciality_id = $request->input('speciality_id');
        $doctor_id = $request->input('doctor_id');
        $patients = Patient::all();
        //dd( $request->all());

        return view('patient.showcalendar', compact('speciality_id', 'doctor_id', 'patient_id', 'patients'));
    }


    public function confirmar(Request $request) {
        //dd("Confirma agenda paciente");
        //dd( $request->all(), $request->input('startTime'), $request->fecha);
        $patient_id = $request->input('patient_id');
        $doctor_id = $request->input('doctor_id');
        $start_time = $request->input('startTime');
        $end_time_ =  Carbon::parse($request->input('startTime'));
        $end_time_->modify('+15 minutes');

        // verifica estado del registro a agendar
        $cita_tmp = Appointment::where('doctor_id', $doctor_id)
                    ->where('date', $request->input('fecha'))
                    ->where('start_time', $start_time)
                    ->where('end_time', $end_time_ )
                    ->select( 'id', 'status')
                    ->first();
        //dd( $cita_tmp);

        if( $cita_tmp ) {
            //dd( $cita_tmp->status );
            switch( $cita_tmp->status->value ) {
                case 1:
                    session()->flash( 'swal' , [
                        'title' => 'Cita ya existe',
                        'text' => 'La cita ya ha sido creada anteriormente !!!!',
                        'icon' => 'error',
                        //'timer' => 3000,
                        'showConfirmButton' => 'Ok'
                    ]); 
                    return redirect()->back();
                    break;
                case 2:
                    dd("Cita Confirmada");
                    break;
                case 3:
                    //dd("Cita Cancelada para reagendar");
                    $appointment = Appointment::where('id', $cita_tmp->id )
                        ->first();

                    if ($appointment) {

                        $appointment->status = 1; // Estado "agendada"
                        $appointment->save();
                        
                        session()->flash( 'swal' , [
                        'title' => 'Agendaniento Confirmado',
                        'text' => 'La cita ha sido agendada con exito !!!!',
                        'icon' => 'success',
                        //'timer' => 3000,
                        'showConfirmButton' => 'Ok'
                        ]); 
                    }

    
                    return redirect()->back();
                    break;
                default:
                    dd("Cita en estado desconocido");
                    break;
            }
        } else {  // No existe agendamiento
            // se crea nuevo registro
            $appointment = new Appointment();
            $appointment->patient_id = $patient_id; // Aquí deberías obtener el ID del paciente autenticado
            $appointment->doctor_id = $request->input('doctor_id');
            $appointment->date = $request->input('fecha');
            $appointment->start_time = $request->input('startTime');

            $appointment->end_time = $end_time_->format('H:i:s');
            $appointment->duration = 15; // Duración fija de 15 minutos, puedes ajustarla según tus necesidades
            $appointment->status = 1; // Estado "confirmada"
            $appointment->save();

            $especialidades = Speciality::all();
            $doctors = Doctor::all();

            $doctor_id = $request->input('doctor_id');

            session()->flash( 'swal' , [
                'title' => 'Agendaniento Confirmado',
                'text' => 'La cita ha sido creada con exito !!!!',
                'icon' => 'success',
                //'timer' => 3000,
                'showConfirmButton' => 'Ok'
            ]); 

            //$patients = Patient::all();

            //return view('admin.agendapatient.showcalendar' , compact("especialidades", "doctors", "doctor_id", "patients") );
            return view('patient.showcalendar', compact('speciality_id', 'doctor_id', 'patient_id', 'patients'));

        }

    }

}
