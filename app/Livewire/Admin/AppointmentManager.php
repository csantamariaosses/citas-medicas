<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use DateTimeZone;


class AppointmentManager extends Component
{


    public $search = [
        'date' => null,
        'hour' => null,
        'speciality_id' => null
    ];

    public $specialities = [];
    public $hola = "Hola mundo";

    #[Computed()]
    public function hourBlocks(){
        return CarbonPeriod::create(
            Carbon::createFromTimeString( config('schedules.start_time') ),
            '1 hour',
            Carbon::createFromTimeString( config('schedules.end_time') )
        )->excludeEndDate();
    }

    public function mount(){
        $this->specialities = \App\Models\Speciality::all();
        $this->dispatch('console-log', ['mensaje' => "MONTADO"]);
        //dd("Montado");
        //dd($this->specialities);
        /*
        $this->days = config('schedules.days');
        $this->apointment_duration = config('schedules.apointment_duration');

        $this->intervals = 60 / $this->apointment_duration;
        $this->start_time = config('schedules.start_time');
        $this->end_time = config('schedules.end_time');
        $this->dispatch('console-log', ['mensaje' => "MONTADO"]);

        //$this->initializeSchedules();
        */
    }   

/*
    public function searchAvailability(){
        console_log("Buscando disponibilidad para: " + JSON.stringify(this.search));
        //$this->dispatch('console-log', ['mensaje' => "Buscando disponibilidad para: " . json_encode($this->search)]);
    }   
*/
    public function searchAvailabilityComp(){
        //$this->dispatch('console-log', ['mensaje' => "Buscando disponibilidad para: " . json_encode($this->search)]);
        //console_log("Buscando disponibilidad para: " + JSON.stringify(this.search));
        //dd( "XXX:" , $this->search );
        $this->validate([
            'search.date' => 'required|date|after_or_equal:today',
            
            'search.hour' => [
                 'required',   
                 'date_format:H:i:s',
                 Rule::when( $this->search['date'] === now()->format('Y-m-d') , [
                    'after_or_equal:' .now()->format('H:i:s')
                 ])
            ],
    
        ]);

    }

    public function render()
    {
        return view('admin.appointment-manager');
    }
}
