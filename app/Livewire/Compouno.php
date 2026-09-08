<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Speciality;
use App\Models\Doctor;


class Compouno extends Component
{
    public $specialities;
    public $doctors;
    public $selectedOption = '';

    public $speciality_id;
    public $doctor_id;

    public $states = [];
    public $cities = [];


    public $state_id = '';
    public $city_id = '';

    public $habilitarBoton = true;



    public function mount()
    {
        $this->states = Speciality::all();
        $this->specialities = Speciality::all();
    }

    public function updatedStateId($value) {
        $this->cities = Doctor::where('speciality_id', $value)->get();
        //dd( $this->cities[0]->user->name);
        $this->city_id = '0'; // Limpiar selección anterior
    }

    
    public function updatedCityId($value) {
        $this->city_id = $value; // Habilitar el botón si se selecciona un médico
        $this->doctor_id = $value; // Habilitar el botón si se selecciona un médico
        $this->habilitarBoton = !empty($value);
    }
        

    /*
    public function updatedSelectedOption($value)
    {
        $this->selectedOption = $value;
        //dd($value); // Para depuración, puedes eliminar esto después
        //$this->doctors = \App\Models\Doctor::where('speciality_id', $value)->get();
        //dd($this->doctors); // Para depuración, puedes eliminar esto después
        $this->dispatch('selectedOption', $this->selectedOption);
    }

    */


    public function render()
    {
        return view('livewire.Compouno', [
            'specialities' => $this->specialities,
            'doctors' => $this->doctors,
            'states' => $this->states,
            'cities' => $this->cities,
        ]);
    }
}
