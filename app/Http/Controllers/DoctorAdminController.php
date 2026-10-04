<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;    
use Barryvdh\DomPDF\Facade\Pdf as DomPdf; // Para Dompdf
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\Doctor;
use App\Models\User;


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

    public function consultaPdf( $idCita ) {
        //dd( $idCita);

        $sql = "select app.id, app.date, app.start_time, ";
        $sql = $sql . "cons.diagnostic, cons.treatment, cons.prescriptions, cons.notes, ";
        $sql = $sql . "users_doc.name as doctorName, spe.name  as specialityName, ";
        $sql = $sql . "users_pat.name as patientName, users_pat.email patientEmail ";  
        $sql = $sql . "from appointments app  ";
        $sql = $sql . "left join consultations cons ";
        $sql = $sql . "on ( app.id = cons.appointment_id) ";
        $sql = $sql . "left join doctors  on ( app.doctor_id = doctors.id) ";
        $sql = $sql . "left join users  users_doc on ( doctors.user_id = users_doc.id) ";
        $sql = $sql . "left join patients on ( app.patient_id = patients.id) ";
        $sql = $sql . "left join users users_pat on ( patients.user_id = users_pat.id)";
        $sql = $sql . "left join specialities spe on ( doctors.speciality_id = spe.id)";
        $sql = $sql . "where app.id = ?;";

        $registro = DB::select( $sql, [ $idCita ] );    

        //dd( $registro );

        $pdf = DomPdf::loadView('pdf.cita',['registro' => $registro[0]]);
        return $pdf->download('cita.pdf');






    }

    public function edit( $id ) {
        //dd("doctor edit mis datos", $id);
        $doctor = Doctor::where('id', $id)->first();
        $user = User::where('id' ,$doctor->user_id)->first();
        //dd( $doctor, $user);
        return view("doctor.edit", compact("doctor", "user"));
    }

    public function consultaSpatiePdf() {
        /*
        $sql = "select app.id, app.date, app.start_time, ";
        $sql = $sql . "cons.diagnostic, cons.treatment, cons.prescriptions, cons.notes, ";
        $sql = $sql . "users_doc.name as doctorName, spe.name  as specialityName, ";
        $sql = $sql . "users_pat.name as patientName, users_pat.email patientEmail ";  
        $sql = $sql . "from appointments app  ";
        $sql = $sql . "left join consultations cons ";
        $sql = $sql . "on ( app.id = cons.appointment_id) ";
        $sql = $sql . "left join doctors  on ( app.doctor_id = doctors.id) ";
        $sql = $sql . "left join users  users_doc on ( doctors.user_id = users_doc.id) ";
        $sql = $sql . "left join patients on ( app.patient_id = patients.id) ";
        $sql = $sql . "left join users users_pat on ( patients.user_id = users_pat.id)";
        $sql = $sql . "left join specialities spe on ( doctors.speciality_id = spe.id)";
        $sql = $sql . "where app.id = ?;";

        $registro = DB::select( $sql, [ $idCita ] );    
*/
        //dd( $registro );

        /*$pdf = DomPdf::loadView('pdf.cita',['registro' => $registro[0]]);
        return $pdf->download('cita.pdf');
        */

        // return Pdf::view('pdf.citaSpatie');
               //->save('storage/app/publi/cita-spatie.pdf');
            
        //return Pdf::loadFile('http://www.github.com')->stream('github.pdf'); 
        return \PDF::loadView('pdf.citaSpatie')->download('nombre-archivo.pdf');
    }
}
