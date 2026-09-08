<?php

use Livewire\Component;

new class extends Component
{
    public $specialities = [];
    public $doctors = [];
    
    public $speciality_id = null;
    public $doctor_id = null;

    public function mount()
    {
        //$this->specialities = Speciality::all();
    }

    // Se ejecuta cada vez que $speciality_id cambia
    /*
    public function updatedSpecialityId($value)
    {
        $this->doctors = Doctor::where('speciality_id', $value)->get();
        $this->doctor_id = null; // Reiniciar el médico seleccionado
    }
*/
    public function render()
    {
        return view('livewire.select-especialidad-medico', [
            'specialities' => $this->specialities,
            'doctors' => $this->doctors,
        ]);
    }
};
?>

<div>
    <p>Este es el componente:</p>
</div>