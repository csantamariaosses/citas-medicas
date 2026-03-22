<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Consultation;
use Illuminate\Support\Facades\DB;



class AppointmentService
{
    public $doctors;
    public $appointment_resumen;
    public $appointments_current;

    // Aquí puedes agregar métodos relacionados con la lógica de las citas médicas
    public function searchAvailability($date, $hour, $speciality_id)
    {
        //dd('AppointmentService:',$date, $hour, $speciality_id);

        $date = Carbon::parse($date);
        $hourStart = Carbon::parse($hour)->format('H:i:s');
        $hourEnd   = Carbon::parse($hour)->addMinutes(15)->format('H:i:s');


         $this->doctors = DB::table('schedules')
                            ->where('day_of_week', $date->dayOfWeek)
                            ->where('start_time', '>=', $hourStart)
                            ->where('start_time', '<', $hourEnd)
                            ->where('speciality_id', $speciality_id)
                            ->join('doctors', 'schedules.doctor_id', '=', 'doctors.id')
                            ->join('users', 'doctors.user_id', '=', 'users.id')
                            ->join('specialities', 'doctors.speciality_id', '=', 'specialities.id')
                            ->select('doctors.id as doctor_id','users.name as doctor', 'specialities.id as speciality_id', 'specialities.name as speciality', 'schedules.day_of_week as dia','schedules.start_time', 'schedules.end_time')
                            ->distinct()
                            ->get();

         return $this->doctors;
    }

    public function guardarCita($date, $doctor_id, $speciality_id, $start_time, $patient_id, $appointment_duration){
        // Aquí puedes implementar la lógica para guardar la cita en la base de datos
       
        //dd("Guardar Cita:Servicio:", $date, $doctor_id, $speciality_id, $start_time, $appointment_duration, $patient_id);

        // Crea nueva cita
        $date = Carbon::parse($date);
        $appointment = new \App\Models\Appointment();
        $appointment->doctor_id = $doctor_id;
        $appointment->patient_id = $patient_id;
        //$appointment->speciality_id = $speciality_id;
        $appointment->date = $date;
        $appointment->start_time = Carbon::createFromFormat('H:i:s', $start_time);
        $appointment->end_time = Carbon::createFromFormat('H:i:s', $start_time)->addMinutes($appointment_duration);
        $appointment->duration = $appointment_duration;
        $appointment->save();

        // cREA NUEVA CONSULTA ASOCIADA A LA CITA
        $last_appointment = $appointment->id;
        $consultation = new Consultation();
        $consultation->appointment_id = $last_appointment;
        $consultation->save();
        return $appointment;


    }

    public function resumenCita($date, $doctor_id, $patient_id, $start_time ){

           $this->appointment_resumen = DB::table('appointments')
                            //->where('date', $date)
                            ->where('doctor_id', $doctor_id)
                            ->where('patient_id', $patient_id)
                            ->where('start_time', $start_time)

                            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
                            ->join('users as user_doc', 'user_doc.id', '=', 'doctors.user_id')                            

                            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
                            ->join('users as user_pac','patients.user_id','=','user_pac.id')
                            ->select('user_doc.name as doctor_name', 'user_pac.name as paciente', 'appointments.date as fecha', 'appointments.start_time as hora_inicio', 'appointments.end_time as hora_fin')
                            ->distinct()
                            ->get();

         return $this->appointment_resumen;
    }


    public function buscaDisponibilidad($date, $hour, $speciality_id){

        // Aquí puedes implementar la lógica para buscar la disponibilidad de los doctores según la fecha, hora y especialidad
/*
        select sch.*, app.*
        from schedules sch
        left join appointments app on sch.day_of_week = dayofweek(app.date) -1
        where app.id is null
*/
        $this->doctors = DB::select('select 
                                    sch.doctor_id, 
                                    day_of_week, 
                                    start_time, 
                                    end_time 
                                    from schedules sch 
                                    left join appointments app on sch.day_of_week = dayofweek(app.date) -1 
                                    left join doctors doc on sch.doctor_id = doc.id
                                    left join specialities sp on doc.speciality_id = sp.id
                                    where doc.speciality_id = ?
                                    and app.start_time = ? 
                                    
                                    where app.id is null', [$speciality_id, $hour]); 
        
        
       
/*
         $this->doctors = DB::table('schedules')
                            ->where('day_of_week', $date->dayOfWeek)
                            ->where('start_time', '>=', $hourStart)
                            ->where('start_time', '<', $hourEnd)
                            ->leftjoin('doctors', 'schedules.doctor_id', '=', 'doctors.id')
                            ->join('users', 'doctors.user_id', '=', 'users.id')
                            ->join('specialities', 'doctors.speciality_id', '=', 'specialities.id')
                            ->select('doctors.id as doctor_id','users.name as doctor', 'specialities.id as speciality_id', 'specialities.name as speciality', 'schedules.day_of_week as dia','schedules.start_time', 'schedules.end_time')
                            ->distinct()
                            ->get();

                            */

         return $this->doctors;
    }


    public function proximasCitas(){
        // Aquí puedes implementar la lógica para buscar las próximas citas
        $this->appointments_current = DB::select('
            select apps.id, apps.date, apps.start_time, apps.end_time, users_doc.name as doctor_name, users_pat.name as patient_name
            from appointments apps
            left join doctors on (apps.doctor_id = doctors.id)
            left join users as users_doc on ( doctors.user_id = users_doc.id)
            left join patients on (  apps.patient_id = patients.id)
            left join users as users_pat on ( patients.user_id = users_pat.id)
            order by apps.date, apps.start_time');
        //dd($this->appointments_current);
        return $this->appointments_current;
    }   

    public function editarCita($appointment_id){
        // Aquí puedes implementar la lógica para editar una cita existente
        $this->appointment_edit = DB::select('
            select apps.id, apps.date, apps.start_time, apps.end_time, users_doc.name as doctor_name, users_pat.name as patient_name
            from appointments apps
            left join doctors on (apps.doctor_id = doctors.id)
            left join users as users_doc on ( doctors.user_id = users_doc.id)
            left join patients on (  apps.patient_id = patients.id)
            left join users as users_pat on ( patients.user_id = users_pat.id)
            where apps.id = ?', [$appointment_id]);
        //dd($this->appointment_edit);
        return $this->appointment_edit;
    }


}

