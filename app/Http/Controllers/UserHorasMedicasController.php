<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Patient;
use App\Models\Speciality;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Enums\AppointmentEnum;
use Barryvdh\DomPDF\Facade\Pdf;


class UserHorasMedicasController extends Controller
{
    public function index()
    {
        $user_id = session('user_id');
        //dd( $user_id);

        $user = User::find($user_id);        
        $patient_id = $user->patient->id;
        //session(['patient_id' => $patient_id]);

        $appointments = Appointment::where('patient_id', $patient_id)->orderBy('date','desc')->get();
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
        $patient_id = $request->input('patient_id');

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

        return view("horasmedicas.showcalendar", compact("schedules", "json_schedules","doctor_id", "doctor", "patient_id", "appointments", "arr_appointments", "arr_schedules"));
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
        $patient_id = $request->input('patient_id');

        session()->flash( 'swal' , [
            'title' => 'Agendaniento Confirmado',
            'text' => 'La cita ha sido creada con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        return view('horasmedicas.showcalendar' , compact("especialidades", "doctors", "doctor_id", "patient_id") );
    }


    public function cancelar(Request $request){
        $appointment_id = $request->input('appointment_id');
        $appointment = Appointment::find($appointment_id);
        if ($appointment) {
            //dd("Cancel", $appointment_id, session('patient_id') );
            $appointment->status = AppointmentEnum::CANCELED; // Estado "cancelada"
            $appointment->save();

            session()->flash( 'swal' , [
                'title' => 'Agendaniento Cancelado',
                'text' => 'La cita ha sido cancelada con exito !!!!',
                'icon' => 'success',
                //'timer' => 3000,
                'showConfirmButton' => 'Ok'
            ]); 
        } else {
            session()->flash( 'swal' , [
                'title' => 'Error',
                'text' => 'No se encontró la cita para cancelar.',
                'icon' => 'error',
                //'timer' => 3000,
                'showConfirmButton' => 'Ok'
            ]); 
        }

        return redirect()->route('horasmedicas.index');
    }   


    public function imprimir($id)
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
        return $pdf->stream('cita.pdf');
    }
}
