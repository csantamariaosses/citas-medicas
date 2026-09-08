<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Speciality;
use App\Models\Doctor;
use Livewire\Attributes\On;

class Compodos extends Component
{
    public $doctors = [];

    #[On('selectedOption')]
    public function recibirDatos($value)
    {

        $doctores = \App\Models\Doctor::where('speciality_id', $value)->get();
        // Asignamos la información recibida a la propiedad
        
        foreach ($doctores as $doctor) {
            $this->doctors = [
                'id' => $doctor->id,
                'name' => $doctor->user->name
            ];   
        }
        //dd($this->doctors->first()->user->name); // Para depuración, puedes eliminar esto después
        //$this->doctors = $info;
    }

    public function render()
    {
        return view('livewire.Compodos', [
            'doctors' => $this->doctors
        ]);
    }
}
