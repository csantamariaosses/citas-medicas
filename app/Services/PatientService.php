<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;


class PatientService
{
    public $patients;

    public function patients()
    {
         $this->patients = DB::table('patients')
                            ->join('users', 'patients.user_id', '=', 'users.id')
                            ->select('patients.id as patient_id', 'users.name as name')
                            ->distinct()
                            ->get();

         return $this->patients;
    }
}

