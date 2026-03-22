<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Consultation;

class ConsultationManager extends Component
{

    public Appointment $appointment;
    public Consultation $consultation;
    public $consultation_id;

    public $form = [
        'diagnostic' => null,
        'treatment' => null,
        'notes'    => null,
        'prescriptions' => []
    ];


    public function mount(Appointment $appointment){
        //dd("Montaje ConsultationManager");
//        dd( $appointment_);
        $this->consultation_id = $appointment->consultation->id;
        $this->form = [
            'diagnostic' => $appointment->consultation->diagnostic,
            'treatment' => $appointment->consultation->treatment,
            'notes' => $appointment->consultation->notes,
            'prescriptions' => $appointment->consultation->prescriptions
        ];

    }

    public function saveConsultation(){
        $this->consultation = Consultation::find($this->consultation_id);

        $this->consultation->diagnostic = $this->form['diagnostic'];
        $this->consultation->treatment = $this->form['treatment'];
        $this->consultation->notes = $this->form['notes'];
        $this->consultation->prescriptions = $this->form['prescriptions'];
        $this->consultation->save();


        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Consulta actualizada',
            'text' => 'La consulta ha sido actualizada'
            ]
        );



    }


    public function addPrescription(){
        //dd("Agregar");
        $this->form['prescriptions'] [] = [
            'medicine' => '',
            'dosage' => '',
            'frequency' => ''
        ];
        //dd( $this->form['presciptions']);
    }

    public function removePrescription($index) {
//        if( count( $this->form['prescriptions'] > 1)) {
            unset($this->form['prescriptions'][$index]);
            $this->form['prescriptions'] = array_values($this->form['prescriptions']);
  //      }
    }

    
    public function render()
    {
        return view('admin.consultation-manager');
    }
}
