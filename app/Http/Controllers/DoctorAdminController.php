<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class DoctorAdminController extends Controller
{
    //
     public function index()
    {
        //
        //dd( session('doctor_id'));
        $appointments = Appointment::where('doctor_id',session('doctor_id'))
                                    ->orderBy('created_at', 'desc')->get();


        return view('doctor.index', compact('appointments'));
    }

    public function updateCita(Request $request ) {
        dd( $request->all());
        $condultation = new Consultation();
        $consultation->appointment_id = $request->cita_id;
        $consultation->diagnostic = $request->diagnostic;
        $consultation->treatment = $request->treatment;
        $consultation->prescription = $request->prescription;
        $consultation->notes = $request->notes;
        $consultation->save();

        
    }
}
