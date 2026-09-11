<?php



namespace App\Http\Controllers\Admin;

session_start();

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Speciality;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\Http;
use DateTime;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        //$_SESSION['paciente'] = "Carlos Santa";
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

        $appointment = Appointment::find( $id);
        return view('admin.appointments.consultation', compact('appointment'));
    }

    public function testSave(Request $request){

        return $request->all();
    }

    public function agendadoc(){
        //Auth::user()->name = "Carlos Santa";
        session(['patient_id' => 0]); // Reemplaza 1 con el ID real del paciente autenticado
        session(['patientName' => 'NN']); // Reemplaza 1 con el ID real del paciente autenticado
       


        $doctors = Doctor::all();
        $schedules = Schedule::all();
        $especialidades = Speciality::all();
        //$patients = Patient::all();
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

        //dd( $request->all() );
        //$doctor_id = $request->input('city_id');
        //$doctor_id = $request->input('doctor');
        

        $doctor_id = $request->input('doctor');

        $doctor = Doctor::find($doctor_id);
        //dd($doctor);

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

        $patients = Patient::all();
        //dd($patients);
      
        $json_schedules = json_encode($schedules);

        return view("admin.agendadoc.showcalendar", compact("schedules", "json_schedules","doctor_id", "doctor", "appointments", "arr_appointments", "arr_schedules", "patients"));
    }

    public function confirmar(Request $request){

        // Cita a confirmar
        $doctor_id = $request->input('doctor_id');
        $patient_id = $request->input('selectPatient_id');
        $start_time = $request->input('startTime');
        $end_time_ =  Carbon::parse($request->input('startTime'));
        $end_time_->modify('+15 minutes');

        // Obtener patiente_id
        if( $request->input('selectPatient_id') != 0) {
            // id viene desde pantalla modal de admin
            $patient_id = $request->input('selectPatient_id');
        } else {
            if( $request->input('patient_id') !=  null ) {
                // id viene desde sesion de usuario
                $patient_id = $request->input('patient_id');
            }
        }
        
        $cita_tmp = Appointment::where('patient_id', $patient_id)
                    ->where('doctor_id', $doctor_id)
                    ->where('date', $request->input('fecha'))
                    ->where('start_time', $start_time)
                    ->where('end_time', $end_time_ )
                    ->first();
        if( $cita_tmp ) {
            session()->flash( 'swal' , [
                'title' => 'Cita ya existe',
                'text' => 'La cita ya ha sido creada anteriormente !!!!',
                'icon' => 'error',
                //'timer' => 3000,
                'showConfirmButton' => 'Ok'
            ]); 
            return redirect()->back();
        }

        //$end_time_ =  Carbon::parse($request->input('startTime'));
        //$end_time_->modify('+15 minutes');

        //dd($request->all());
        //dd( $end_time_->format('H:i:s') );

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

        $patients = Patient::all();

        return view('admin.agendadoc.showcalendar' , compact("especialidades", "doctors", "doctor_id", "patients") );
    }

    public function buscahorasreservadas(Request $request) {
        
         $response = Http::get('http://localhost:8080/api/buscahorasreservadas');
         return response->json();
        
    }


    public function cancelarCita(Request $request) {


        /*dd( $request->input('modalCitaIdAgHidden') );
        dd( $request->input('modalPatientIdAgHidden') );
        dd( $request->input('modalDoctorIdAgHidden') );
        dd( $request->input('modalFechaStartAgHidden') );
        dd( $request->input('modalFechaHoraStartAgHidden') );
        */

        $appointment_id = $request->input('modalCitaIdAgHidden');
        $doctor_id      = $request->input('modalDoctorIdAgHidden');
        $patient_id     = $request->input('modalPatientIdAgHidden');
        $fecha          = $request->input('modalFechaStartAgHidden');
        $hora_start     = $request->input('modalFechaHoraStartAgHidden');
        
        $appointment = Appointment::where('id', $appointment_id)
                        ->where('doctor_id', $doctor_id)
                        ->where('patient_id', $patient_id)
                        ->where('date', $fecha)
                        ->where('start_time', $hora_start)
                        ->first();

        if ($appointment) {

            $appointment->status = 3; // Estado "cancelada"
            $appointment->save();
            
            session()->flash( 'swal' , [
            'title' => 'Agendaniento Cancelado',
            'text' => 'La cita ha sido cancelada con exito !!!!',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        $patients = Patient::all();
        $especialidades = Speciality::all();
        $doctors = Doctor::all();   
        $patients = Patient::all();

        return view('admin.agendadoc.showcalendar' , compact("especialidades", "doctors", "doctor_id", "patients") );
        } else {
            return response()->json(['success' => false, 'message' => 'Cita no encontrada.'], 404);
        }
    }

    public function agendadocfull(){
        $especialidades = Speciality::all();
        $doctors = Doctor::all();
        $patients = Patient::all();

        $appointments = Appointment::where('status', '!=', 3)->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();

        return view("admin.agendafull.index", compact("appointments"));
    }

    public function dashboard(){
        /*
        $especialidades = Speciality::all();
        $doctors = Doctor::all();
        $patients = Patient::all();

        $appointments = Appointment::where('status', '!=', 3)->orderBy('date', 'desc')->orderBy('start_time', 'desc')->get();

        return view("admin.dashboard.index");
        */
        //-return "Dashboard";
        return view("admin.dashboard.index");
    }
}
