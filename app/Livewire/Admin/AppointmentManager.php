<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use DateTimeZone;
use App\Services\AppointmentService;
use App\Services\PatientService;
use App\Models\Patient;



class AppointmentManager extends Component
{


    public $search = [
        'date' => null,
        'hour' => null,
        'speciality_id' => null
    ];

    public $date;
    public $specialities = [];
    public $availability = [];
    public $hola = "Hola mundo";
    public $intervals;
    public $selectedSchedules = [];
    public $appointment_edit = [];

    public $upcomingAppointments = [];

    public $patient = [
        'patient_id',
        'name'
    ];
    public $patientService;

    public $pacientes;
    public $patients = [];

    public $appointment = [
        'patient_id' => '',
        'doctor_id' => '',
        'date' => '',
        'start_time' => '',
        'end_time' => '',
        'duration' => '',
        'reason' => ''
    ];

    public $resumen_cita = [];

    public $appointments_current = [];
    public $appointment_duration = 15;

    #[Computed()]
    public function hourBlocks(){
        return CarbonPeriod::create(
            Carbon::createFromTimeString( config('schedules.start_time') ),
            '1 hour',
            Carbon::createFromTimeString( config('schedules.end_time') )
        )->excludeEndDate();
    }

    public function mount(){
        $servicio = app('App\Services\PatientService');
        $this->patients = $servicio->patients();
        //dd( $this->patients );

        $this->specialities = \App\Models\Speciality::all();

        // Si es mas de las 12 horas se impide agendar para el mismo dia
        // solo permite agendar para el dia
        $this->search['date'] = now()->hour >= 12 ?
                            now()->addDay()->format('Y-m-d')
                          : now()->format('Y-m-d');
        $this->intervals = 60 / $this->appointment_duration;

        $this->date = $this->search['date'];
        $this->proximasCitas(app('App\Services\AppointmentService'));
    }   

    public function searchAvailability(AppointmentService $service){

    /*
        $this->validate([
            'search.date' => 'required|date|after_or_equal:today',
                'search.hour' => [
                    'required',   
                    'date_format:H:i:s',
                    Rule::when( $this->search['date'] === now()->format('Y-m-d') , [
                        'after_or_equal:' .now()->format('H:i:s')
                    ])
                ]
        ]);
*/
        // Buscar disponibilidad
        $this->availability = $service->searchAvailability(...$this->search);
        $this->appointment['date'] = $this->search['date'];
        $this->availability->toArray();

       // dd( "Disponibilidad: ", $this->availability );

        //$this->appointment['date'] = $this->search['date'];
        
    }


    public function searchAvailabilityComp( AppointmentService $appointmentService ){
        $this->validate([
            'search.date' => 'required|date|after_or_equal:today',
            
            'search.hour' => [
                 'required',   
                 'date_format:H:i:s',
                 Rule::when( $this->search['date'] === now()->format('Y-m-d') , [
                    'after_or_equal:' .now()->format('H:i:s')
                 ])
            ],
        ]);

        //dd("Paso validacion");

        $this->appointment['date'] = $this->search['date'];


        // Buscar disponibilidad
        $this->availability = $appointmentService->searchAvailability(...$this->search);

        //dd( "Disponibilidad: ", $this->appointmentService );

        //dd( "Disponibilidad: ", $this->availability );

    }


    public function guardarCita( $date , $doctor_id, $speciality_id, $start_time, $patient_id, AppointmentService $appointmentService ){
        //dd("Guardar cita para el horario: ", "doctor_id:", $doctor_id, "especialidad_id#", $speciality_id, "fecha:", $this->appointment['date'], "hora_inicio:", $start_time, "paciente_id:", $patient_id);

        $appointmentService->guardarCita($date, $doctor_id, $speciality_id, $start_time, $patient_id, $this->appointment_duration);

        $this->resumen_cita = $appointmentService->resumenCita($date, $doctor_id, $patient_id, $start_time);
        $this->appointments_current = $appointmentService->proximasCitas();
        //dd("Resumen cita:", $this->resumen_cita);

         $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Cita actualizada',
            'text' => 'La cita ha sido actualizada exitosamente.'
            ]
        );

    }


    public function proximasCitas(AppointmentService $appointmentService){
        $this->appointments_current = $appointmentService->proximasCitas();
        //dd( "Próximas citas: ", $this->appointments_current );
    }


    public function editarCita($appointment_id, AppointmentService $appointmentService){
        //dd("Editar cita con ID: ", $appointment_id);
        $this->appointment_edit = $appointmentService->editarCita($appointment_id);
        //dd( "Datos de la cita a editar: ", $this->appointment_edit );


    }   

    public function render()
    {
        return view('admin.appointment-manager');
    }
}
