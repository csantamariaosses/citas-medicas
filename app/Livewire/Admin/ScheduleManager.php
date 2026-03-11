<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use App\Models\Doctor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use DateTimeZone;

class ScheduleManager extends Component
{
    public Doctor $doctor;
    public $scheduleDb;
    public $schedules = [];
    public $days = [];

    public $apointment_duration; //
    public $start_time;
    public $end_time;
    public $intervals;
    public $indexDay, $hour;
    public $estado = false;
    
    #[Computed()]
    public function hourBlocks(){
        return CarbonPeriod::create(
            Carbon::createFromTimeString( $this->start_time),
            '1 hour',
            Carbon::createFromTimeString( $this->end_time )
        )->excludeEndDate();
    }

    public function mount(Doctor $doctor){
        $this->days = config('schedules.days');
        $this->apointment_duration = config('schedules.apointment_duration');

        $this->intervals = 60 / $this->apointment_duration;
        $this->doctor = $doctor;
        $this->start_time = config('schedules.start_time');
        $this->end_time = config('schedules.end_time');
        $this->dispatch('console-log', ['mensaje' => "MONTADO"]);

        $this->initializeSchedules();
    }   

    public function initializeSchedules(){
        $schedules = $this->doctor->schedules;

        foreach($this->hourBlocks as $hourBlock){
            $period = CarbonPeriod::create(
                $hourBlock->copy(),
                $this->apointment_duration . ' minutes',
                $hourBlock->copy()->addHour()
            );

            foreach( $period as $time ){

                foreach($this->days as $index => $day){
                    
                    $this->schedules[$index][$time->format('H:i:s')] =  $schedules->contains(function($var) use ($index, $time){
                        if( $var->day_of_week == $index && $var->start_time->format('H:i:s') == $time->format('H:i:s') ){
                            return true;
                        }
                        return false;
                    });
                }                      
            }   
        } 

       $this->dispatch('console-log', ['mensaje' => "SCHEDULES INICIALIZADOS"]);
       $this->dispatch('console-log', ['mensaje' => $this->schedules]);
       
                
    }
    
    

    public function cambiaCheckTodos(int $indexDay, string $hour){
        // Aquí puedes manejar la lógica para marcar o desmarcar los bloques de horas
        $this->indexDay = $indexDay;
        $this->hour = $hour;

        if( $this->chkbx_t_1_0800 == false ){
            $this->chkbx_t_1_0800 = true;
        }

    }   

    public function clickTodo($indexDay , $hour_str){

        $property = "chkbx_t_{$indexDay}_{$hour_str}";
        $this->$property = !$this->$property;
    }

    public function toggleHourBlock($indexDay, $hour, $evento){ 
        $this->indexDay = $indexDay;
        $this->hour = $hour;
        $this->estado = $evento;
        $this->dispatch('console-log', ['mensaje' => "::indexDay: $indexDay, hour: $hour, evento: $this->estado"]);

    }

    public function saveSchedules(){
        //dd("Guardando horarios...");
        $this->doctor->schedules()->delete(); // Elimina los horarios existentes del doctor

         foreach($this->schedules as $day_of_week => $intervals){
            foreach($intervals as $start_time => $isChecked){
                //dd( "Guardando horario: Día: $day_of_week, Hora: $start_time, Estado: $isChecked");
                if($isChecked){
                    
                    $hora_fin = Carbon::createFromTimeString($start_time)
                                ->addMinutes($this->apointment_duration)
                                ->format('H:i:s');
                    
                    $schedule = new \App\Models\Schedule();
                    $schedule->doctor_id = $this->doctor->id;
                    $schedule->day_of_week = $day_of_week;
                    $schedule->start_time = $start_time;
                    $schedule->end_time = $hora_fin;
                    $schedule->created_at = Carbon::now();
                    $schedule->updated_at = Carbon::now();
                    $schedule->save();

                }
            }
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Horario actualizado',
            'text' => 'Los horarios del doctor han sido actualizados exitosamente.'
            ]
        );
        //dd( "Horarios guardados exitosamente." );
    }   

    public function render()
    {
        $doctor = $this->doctor;
        $days = $this->days;
    
        return view('admin.schedule-manager', compact('doctor','days'));
    }
}
