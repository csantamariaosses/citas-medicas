<?php



namespace App\Http\Controllers\Admin;

session_start();

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Speciality;
use Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\Http;
use DateTime;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $_SESSION['paciente'] = "Carlos Santa";
        return view('admin.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.appointments.store');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.appointments.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.appointments.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return view('admin.appointments.update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return view('admin.appointments.destroy');
    }

    public function consultation($id){
        //return "Consulta_id:: $id";
        $appointment = Appointment::find( $id);
        //dd("AppointmentController::", $appointment);
        //dd( $appointment, $appointment->consultation);
       // return null;
       //return "Consultation";

        return view('admin.appointments.consultation', compact('appointment'));
    }

    public function testSave(Request $request){

        return $request->all();
        /*
        $appointment = new Appointment();
        $appointment->patient_id = $request->patient_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->date = $request->date;
        $appointment->start_time = $request->start_time;
        $appointment->end_time = $request->end_time;
        $appointment->duration = $request->duration;
        $appointment->status = 1;
        $appointment->save();


        return redirect()->route('calendar.test')->with('success', 'Reserva guardada exitosamente.');
        */
    }

    public function agendadoc(){
        //Auth::user()->name = "Carlos Santa";
        session(['patient_id' => 1]); // Reemplaza 1 con el ID real del paciente autenticado
        session(['patientName' => 'Carlos Santa Maria']); // Reemplaza 1 con el ID real del paciente autenticado
       


        $doctors = Doctor::all();
        $schedules = Schedule::all();
        $especialidades = Speciality::all();
        //dd($doctors, $schedules, $especialidades);
        return view("admin.agendadoc.index", compact("doctors", "especialidades", "schedules"));

    }

    public function especialidad(Request $request){
        $patient_id = $request->input('patient_id');
        $especialidad_id = $request->input('especialidad');
        $speciality = Speciality::find( $especialidad_id);
        //dd( $speciality );
        $specialityName = $speciality->name;
        session(['specialityName' => $specialityName]);
        //dd( session( 'specialityName') );

        $doctors = Doctor::where('speciality_id', $especialidad_id)->get();
        //dd($doctors);
        return view("admin.agendadoc.showdoctors", compact("doctors", "patient_id"));
                                     
    }   

    public function busDoctorByEspecialidad(Request $request){
        $especialidad_id = $request->input('especialidad');
        $doctors = Doctor::where('speciality_id', $especialidad_id)->get();
        dd($especialidad_id);
        return response()->json($doctors);
    }

    public function showcalendar(Request $request){
        //dd("function Showcalendar");
        $doctor_id = $request->input('doctor');
        session(['doctor_id' => $doctor_id]);
        $doctor = Doctor::find($doctor_id);
        $doctorName = $doctor->user->name;

        //dd("doctorName: sesion" , $doctor->user->name);
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

        //dd( $arr_schedules[0]['day_of_week'],$arr_schedules[0]['start_time'], $arr_schedules[0]['end_time'] );
        // GENERANDO DIAS DEL MES PARA PRUEBAS
        //$mes = 4; // Abril
        //$anio = 2026;
        //$totalDias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio); // 

        //$diasMes = [];
        //for ($i = 1; $i <= $totalDias; $i++) {
            // Formatear como YYYY-MM-DD

        //    $diasMes[] = [
        //            'fecha' => date('Y-m-d', strtotime("$anio-$mes-$i")),
        //            'posicion' => date('w', strtotime( date('Y-m-d', strtotime("$anio-$mes-$i"))))
         //   ];
            
        //}   

        //dd( $diasMes );
        //$posicionDia = $arr_schedules[0]->day_of_week;
        //$fechaDeEseDia = date('Y-m-d', strtotime($posicionDia));
        //dd( $posicionDia, $fechaDeEseDia );
      
        //dd($arr_appointments);
        $json_schedules = json_encode($schedules);
        //dd( $schedules_json);
        //$schedules = $schedules->toArray();

        //dd( $schedules, $arr_schedules);

        return view("admin.agendadoc.showcalendar", compact("schedules", "json_schedules","doctor_id", "doctor", "appointments", "arr_appointments", "arr_schedules"));
    }

    public function confirmar(Request $request){
        $end_time_ = new DateTime($request->input('startTime'));
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
        $appointment->save();

        $especialidades = Speciality::all();
        $doctors = Doctor::all();

        session()->flash( 'swal' , [
            'title' => 'Agendaniento Confirmado',
            'text' => 'La cita ha sido creada con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        return view('index', compact('especialidades', 'doctors'))->with('success', 'Cita confirmada exitosamente.');
    }

    public function buscahorasreservadas(Request $request) {
        
         $response = Http::get('http://localhost:8080/api/buscahorasreservadas');
         return response->json();
        
    }

}
