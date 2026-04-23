<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Speciality;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use Carbon\Carbon;

class UserHorasMedicasController extends Controller
{
    public function index()
    {
        $user_id = session('user_id');
        $user = User::find($user_id);        
        $patient_id = $user->patient->id;
        session(['patient_id' => $patient_id]);

        $appointments = Appointment::where('patient_id', $patient_id)->orderBy('date')->get();
        $especialidades = Speciality::all();
        $doctors = Doctor::all();
        // dd(  $patient_id );
        return view("horasmedicas.index", compact('especialidades','doctors', 'appointments') );    

    }

    public function doctores(Request $request)
    {

        $patient_id = $request->input('patient_id');
        $especialidad_id = $request->input('especialidad');
        $speciality = Speciality::find( $especialidad_id);
        //dd( $speciality );
        $specialityName = $speciality->name;
        session(['specialityName' => $specialityName]);
        
        //dd( session( 'specialityName') );

        $doctors = Doctor::where('speciality_id', $especialidad_id)->get();
        //dd($doctors);
        return view("horasmedicas.showdoctors", compact("doctors", "patient_id"));
    
    }

    public function showcalendar(Request $request)
    {
        $doctor_id = $request->input('doctor');
        $doctor = Doctor::find($doctor_id);
        $doctorName = $doctor->user->name;

        session(['doctor_id' => $doctor_id]);
        session(['doctorName' => $doctorName]);



        $schedules = Schedule::where('doctor_id', $doctor_id)->get();
        $appointments = Appointment::where('doctor_id', $doctor_id)->get();

        $arr_appointments_shrt = [];
        foreach( $appointments as $appointment ){
            $arr_appointments_srt[] = [                
                'doctor_id' => $appointment->doctor_id,
                'date'      => $appointment->date->format('Y-m-d'),
                'fechaInicio' => $appointment->date->format('H:i:s'),
                'fechaFin' => $appointment->date->format('H:i:s')
            ];
        }

        forEach( $arr_appointments_shrt as $app_srt ) {
             dd("APP_SHRT");
        }
        
        $arr_appointments = [];
        foreach( $appointments as $appointment ){
            $arr_appointments[] = [                
                'fechaInicio' => $appointment->date->format('Y-m-d'). 'T'. $appointment->start_time->format('H:i:s'),
                'fechaFin' => $appointment->date->format('Y-m-d'). 'T'. $appointment->end_time->format('H:i:s')
            ];
        }
        $arr_schedules = [];
        foreach( $schedules as $schedule ){
            $arr_schedules[] = [
                'doctor_id' => $schedule->doctor_id,
                'day_of_week' => $schedule->day_of_week,
                'start_time' => $schedule->start_time->format('H:i:s'),
                'end_time' => $schedule->end_time->format('H:i:s')
            ];
        };

      
        $json_schedules = json_encode($schedules);

        return view("horasmedicas.showcalendar", compact("schedules", "json_schedules","doctor_id", "doctor", "appointments", "arr_appointments", "arr_schedules"));
    }

    public function listhorasagendadas() {
        dd( pacient_id , doctor_id );

    }

    public function confirmar(Request $request){
        //$end_time_ = new Date($request->input('startTime'));
        $end_time_ =  Carbon::parse($request->input('startTime'));
        $end_time_->modify('+15 minutes');

        //dd($request->all());
        //dd( $end_time_->format('H:i:s') );

        $appointment = new Appointment();
        $appointment->patient_id = $request->input('patient_id'); // Aquí deberías obtener el ID del paciente autenticado
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->date = $request->input('fecha');
        $appointment->start_time = $request->input('startTime');

        $appointment->end_time = $end_time_->format('H:i:s');
        $appointment->duration = 15; // Duración fija de 15 minutos, puedes ajustarla según tus necesidades
        $appointment->status = 1; // Estado "confirmada"
        /*
        $appointment->extendedProps = json_encode([
            'patient_id' => session('patient_id'),
            'pacienteName' => session('patientName'),
            'doctorName' => session('doctorName'),
            'specialityName' => session('specialityName')
        ]);
        */
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

        return view('horasmedicas.showcalendar' , compact("especialidades", "doctors", "doctor_id") );
    }

}
