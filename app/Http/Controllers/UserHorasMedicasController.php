<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Speciality;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;

class UserHorasMedicasController extends Controller
{
    public function index()
    {
        $especialidades = Speciality::all();
        $doctors = Doctor::all();
        return view("horasmedicas.index", compact('especialidades','doctors'));    

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
}
