<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class CalendarController extends Controller
{
    public function index(){
        return view("admin.calendar.index");
    }

     public function test(){
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view("admin.calendar.test", compact('patients', 'doctors'));
        
    }
}
