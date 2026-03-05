<?php

namespace App\Services;
use Carbon\Carbon;


class AppointmentService
{
    // Aquí puedes agregar métodos relacionados con la lógica de las citas médicas
    public function searchAvailability($date, $hour, $speciality_id)
    {
        //dd($date, $hour, $speciality_id);
        $date = Carbon::parse($date);
        $hourStart = Carbon::parse($hour)->format('H:i:s');
        $hourEnd   = Carbon::parse($hour)->addHour()->format('H:i:s');
 
        $doctors = \App\Models\Doctor::whereHas('schedules', function($query) use ($date, $hourStart, $hourEnd){
            $query->where('day_of_week', $date->dayOfWeek)
                  ->where('start_time', '>=', $hourStart)
                  ->where('start_time', '<', $hourEnd);
        })
        ->when($speciality_id, function($query, $speciality_id) {
            return $query->where('speciality_id', $speciality_id);
        })
        ->with([
          'user',
          'speciality',
          'schedules' => function($query) use ($date, $hourStart, $hourEnd){
            $query->where('day_of_week', $date->dayOfWeek)
                  ->where('start_time', '>=', $hourStart)
                  ->where('start_time', '<', $hourEnd);
           },
           'appointments' => function($query) use ($date, $hourStart, $hourEnd){
              $query->whereDate('date', $date)
                  ->where('start_time', '>=', $hourStart)
                  ->where('start_time', '<', $hourEnd);
            }
        ])
        ->get();

        dd( $doctors->toArray());

    }
}

