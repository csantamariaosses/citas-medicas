<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Speciality;
use App\Models\Doctor;
use App\Models\Appointment;


class DoctorTablaCitasComponent extends Component
{
    public $appointments = [];
    /*
    public $specialities = [];
    public $doctors = [];
    public $selectedOption = '';

    public $speciality_id;
    public $doctor_id;


    public $states = [];
    public $cities = [];
    public $state_id = '';
    public $city_id = '';
    */



    //public $habilitarBoton = true;



    public function mount( $doctor_id )
    {
        //dd( $doctor_id );

        $this->appointments = Appointment::where('doctor_id', $doctor_id)->get();
    }


    public function render()
    {
        return view('livewire.DoctorTablaCitasComponent', [
            'appointments' => $this->appointments
            ]);
    }
}
