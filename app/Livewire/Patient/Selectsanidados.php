<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Speciality;
use App\Models\Doctor;



class Selectsanidados extends Component
{
    public $countries;
    public $cities = [];

    public $selectedCountry = null;
    public $selectedCity = null;

    public function mount()
    {
        $this->countries = Speciality::all();
    }

    // Se ejecuta automáticamente cuando $selectedCountry cambia
    public function updatedSelectedCountry($countryId)
    {

        $this->cities = Doctor::where('speciality_id', $countryId)->get();
        $this->selectedCity = null; // Reiniciar el segundo select
        $this->selectedCountry = $countryId;
        //dd("aaaaa");
    }

    public function render()
    {
        return view('livewire.Patient.Selectsanidados');
    }
}