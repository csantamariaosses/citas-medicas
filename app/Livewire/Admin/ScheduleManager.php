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
    public $days = [
        1 => "Lunes",
        2 => 'Martes', 
        3 => 'Miércoles',
        4 => 'Jueves', 
        5 => 'Viernes', 
        6 => 'Sábado', 
        0 => 'Domingo'];
    
    public $apointment_duration = 15; // Duración de la cita en minutos        
    public $intervals;
    public $indexDay, $hour;
    public $estado = false;
    
    #[Computed()]
    public function hourBlocks(){
        return CarbonPeriod::create(
            Carbon::createFromTimeString('08:00:00'),
            '1 hour',
            Carbon::createFromTimeString('18:00:00')
        )->toArray();
    }

    public function mount(Doctor $doctor){
        $this->intervals = 60 / $this->apointment_duration;
        $this->doctor = $doctor;
        $this->dispatch('console-log', ['mensaje' => "MONTADO"]);

        $this->initializeSchedules();
    }   

    public function initializeSchedules(){
        $schedules = $this->doctor->schedules;

        /*
         $this->dispatch('console-log', ['mensaje' => "initializeSchedules()"]);
         $this->scheduleDb = \App\Models\Schedule::all();
         //$this->schedulesDb = $this->doctor->schedules();
         $this->dispatch('console-log', ['mensaje' => $this->scheduleDb]);
        */
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
        //dd($this->schedules);


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
                    //$timezone = new DateTimeZone('America/Santiago');
                    //$date->setTimezone('Europe/Paris');
                    
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
        /*
        $this->dispatch('console-log', ['mensaje' => "Horarios guardados correctamente."]);
        
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Horario actualizado correctamente',
            'text' => "Horarios guardados correctamente."
        ]);
        */
        //$this->dispatch('console-log', ['mensaje' => "Guardando horarios..."]);
        //$this->dispatch('console-log', ['mensaje' => $this->schedules]);

        // Aquí puedes implementar la lógica para guardar los horarios en la base de datos
    }   

    public function render()
    {
        $doctor = $this->doctor;
        $days = $this->days;
    
        return view('admin.schedule-manager', compact('doctor','days'));
    }
}
