<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiProductosController;   
use App\Models\Appointment; 
use App\Models\Schedule; 
use App\Models\User; 
use App\Models\Fechaposdia; 
use Carbon\Carbon;

Route::get('/prueba', function (Request $request) {
    return "Esta es una ruta de prueba"; 
});

Route::get('/productos', [ApiProductosController::class, 'index']);


Route::post('/productos', function (Request $request) {
    return "Creando Producto"; 
});

Route::put('/productos/{id}', function (Request $request) {
    return "Actualizando Producto"; 
});



Route::delete('/productos/{id}', [ApiProductosController::class, 'destroy']);


Route::get('appointments', function( Request $request) {
    $appointments = Appointment::with( ['patient.user','doctor.user'])
       ->whereBetween('date', [ $request->start, $request->end])
       ->get();

   // return $appointments->start;

    return $appointments->map( function( $var ) {
        return [
            'id' => $var->patient_id,
            'title' => $var->patient->user->name,
            'start' => $var->start,
            'end'   => $var->end,
            'extendedProps' => [
                /*
                'patient_id' => $var->patient_id,
                'doctor_id' => $var->doctor_id,
                'date'  => $var->date->format('Y-m-d'),
                'start_time' => $var->start_time->format('H:i:s'),
                'end_time' => $var->end_time->format('H:i:s')
                */
            ]
        ];
    });
    
})->name('api.appointments.index');


Route::get('appointmentsByDoctorId', function( Request $request) {
    $appointments = Appointment::where('doctor_id', $request->doctor_id)
                    ->select('id','doctor_id','patient_id', 'date', 'start_time','end_time')
                    ->get();

   
    
    $respuesta =  $appointments->map( function( $var ) {
        return [
            'id'         => $var->id,      
            'doctor_id'  => $var->doctor_id,
            'patient_id' => $var->patient_id,
            'date'       => $var->date->format('Y-m-d'),
            'start_time' => $var->start_time->format('H:i:s'),
            'end_time'   => $var->end_time->format('H:i:s')
        ];
    });

    //dd( $respuesta);

    return response()->json( $respuesta, 200 );
    

    
})->name('api.appointmentsByDoctorId');



Route::get('schedules', function( Request $request) {
    //dd($request->doctor_id);
    $schedules = Schedule::all();
    $schedules = Schedule::where('doctor_id', $request->doctor_id)->get();

   // dd( $schedules );
                          
    return $schedules->map( function( $var ) {
        return [
            'doctor_id' => $var->doctor_id,
            'title' => $var->doctor->user->name,
            'day_of_week' => $var->day_of_week,
            'startTime' => $var->start_time,
            'endTime'   => $var->end_time
            ];
    })->values(); 
})->name('api.schedules');

 Route::get('generatablafechaposdia', function ( Request $request) {
          
        $inicio = Carbon::now()->startOfMonth();
        $fin = Carbon::now()->addMonth()->endOfMonth();
        

        Fechaposdia::truncate();

        
        $diasMes = [];
        
        while ($inicio->lte($fin)) {
            $diasMes[] = $inicio->copy();

            $fechaposdia = new Fechaposdia();
            $fechaposdia->fecha = $inicio->copy();
            $fechaposdia->day_of_week = $inicio->copy()->dayOfWeek;;
            $fechaposdia->created_at = Carbon::now(); 
            $fechaposdia->updated_at = Carbon::now(); 
            $fechaposdia->save();

            $inicio->addDay();
        }
        

        $inicioNextMonth = Carbon::now()->addMonth()->startOfMonth();
        $finNextMonth = Carbon::now()->addMonth()->endOfMonth();

        while ($inicioNextMonth->lte($finNextMonth)) {
            //$diasMes[] = $inicioNextMonth->copy();

            $fechaposdia = new Fechaposdia();
            $fechaposdia->fecha = $inicioNextMonth->copy();
            $fechaposdia->day_of_week = $inicioNextMonth->copy()->dayOfWeek;;
            $fechaposdia->created_at = Carbon::now(); 
            $fechaposdia->updated_at = Carbon::now(); 
            $fechaposdia->save();

            $inicioNextMonth->addDay();
        }

        

          
        return response()->json( $diasMes, 200);

})->name('generatablafechaposdia');


Route::get('buscahorasdiponibles', function( Request $request) {
    
        $resultados = DB::table('fechaposdias')
                    ->leftJoin('schedules', 'fechaposdias.day_of_week', '=', 'schedules.day_of_week')
                    ->leftJoin('appointments', function ($join) {
                        $join->on('fechaposdias.fecha', '=', 'appointments.date')
                             ->on('schedules.start_time', '=', 'appointments.start_time');
                    })
                    ->where( 'schedules.doctor_id' , '=',3 )
                    ->whereNull( 'appointments.date'  )
                    ->orderBy('fechaposdias.fecha')
                    ->orderBy('schedules.start_time' )
                    ->select('fechaposdias.fecha', 'fechaposdias.day_of_week', 'schedules.start_time','schedules.end_time','appointments.date' )
                    ->get();

            return response()->json( $resultados, 200);
});

Route::get('buscahorasreservadas', function( Request $request) {
    
        $resultados = DB::table('appointments')
                 ->where( 'appointments.doctor_id','=',3)
                 ->select('date', 'start_time','end_time')
                 ->get();

        return response()->json( $resultados, 200);
});