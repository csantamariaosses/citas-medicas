<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Speciality;
use App\Models\Doctor;


class Compouno extends Component
{
    public $specialities = [];
    public $doctors = [];
    public $selectedOption = '';

    public $speciality_id = null;
    public $doctor_id = null;
    public $habilitarBoton = true;

    public function mount()
    {
        $this->specialities = Speciality::all();
        $this->doctors = Doctor::all();
        $this->speciality_id = false; // Inicialmente habilitado
    }


    public function updatedSpecialityId($value) {
       // dd("updatedSpecialityId");
        $this->doctors = Doctor::where('speciality_id', $value)->get();
        $this->doctor_id = '0'; // Limpiar selección anterior
       // dd("ya paso especialidad");

    }

/*
    public function updatedId($value) {
        dd("updatedId");
        $this->cities = Doctor::where('speciality_id', $value)->get();
        //dd( $this->cities[0]->user->name);
        $this->city_id = '0'; // Limpiar selección anterior
    }
*/
    
    public function updatedDoctorId($value) {
        dd("doctor");

        $this->doctor_id = $value; 
        $this->habilitarBoton = !empty($value); // Habilitar el botón si se selecciona un médico
    }

    public function update($value) {
        dd("doctor");

        $this->doctor_id = $value; 
        $this->habilitarBoton = !empty($value); // Habilitar el botón si se selecciona un médico
    }
        


    public function render()
    {
        //dd("render");
        return view('livewire.Patient.Compouno', [
            'specialities' => $this->specialities,
            'doctors' => $this->doctors,
        ]);
    }
}
