<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiProductosController;   
use App\Models\Appointment; 

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
                
                'patient_id' => $var->patient_id,
                'doctor_id' => $var->doctor_id,
                'date'  => $var->date->format('Y-m-d'),
                'start_time' => $var->start_time->format('H:i:s'),
                'end_time' => $var->end_time->format('H:i:s')
                
            ]
        ];
    })->values();
    
})->name('api.appointments.index');


