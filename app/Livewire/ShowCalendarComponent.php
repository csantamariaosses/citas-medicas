<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Speciality;
use App\Models\Doctor;


class ShowCalendarComponent extends Component
{
    public $specialities = [];
    public $doctors = [];
    public $selectedOption = '';

    public $speciality_id;
    public $doctor_id;


    public $states = [];
    public $cities = [];
    public $state_id = '';
    public $city_id = '';



    public $habilitarBoton = true;



    public function mount( $doctor_id )
    {
        //dd( $doctor_id );
        $this->doctor_id = $doctor_id;
    }


    public function render()
    {
        return view('livewire.ShowCalendarComponent', [
            'doctor_id' => $this->doctor_id
            ]);
    }
}
