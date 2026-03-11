<div x-data="tblData()" x-init="inicio()" style="background-color: #e0e0e0; padding: 20px; border-radius: 5px;">
  <h3> Administrar Horarios - vista componente </h3>
  <p>Doctor: {{ $doctor->user->name }}</p>
  <hr>
  <div class="overflow-x-auto" style="width: 1200px;">
    <div>
        DAY:{{ var_export($this->indexDay) }} - HORA:{{ var_export($this->hour) }} - ESTADO {{ var_export($this->estado)}}
    </div>
    <div>
        <button wire:click="saveSchedules" class="btn btn-primary">
            Guardar Horarios
        </button>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th style="text-transform: uppercase; padding: 20px;">
                    Día/Hora 
                </th>
                @foreach($days as $index => $day)
                    <th style="text-transform: uppercase; padding: 20px;">
                       {{$index}} - {{ $day }} 
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
              @foreach($this->hourBlocks as $hourBlocks)
                   @php
                        // Formateo a string
                        $hour = $hourBlocks->format('H:i:s');                                
                   @endphp
                    <tr>
                        <td>
                          <input type="checkbox" x-on:click="toggleFullHourBlock( '{{ $hour }}', $event.target.checked) "
                          :checked="isFullHourBlockChecked('{{ $hour }}')">
                          <span>
                            {{ $hour }}
                          </span>
                        </td>
                        <div>
                        @foreach($days as $indexDay => $day)
                            <td>
                                <label>
                                    <input type="checkbox" x-on:click="toggleHourBlock( '{{ $indexDay }}', '{{ $hour }}', $event.target.checked) "
                                    :checked="isHourBlockChecked('{{ $indexDay }}', '{{ $hour }}')">
                                    <span class="ml-2">
                                      Todos..
                                    </span>
                                </label>  
                                @for( $i=0; $i<$this->intervals; $i++ )
                                    @php
                                        $startTime = $hourBlocks->copy()->addMinutes($i * $this->apointment_duration);
                                        $endTime = $startTime->copy()->addMinutes($this->apointment_duration);
                                
                                    @endphp
                              
                                    <div>
                                        <label>
                    
                                            <!-- aqui va el checkbox -->
                                             <input type="checkbox" x-model="schedules['{{ $indexDay }}']['{{ $startTime->format('H:i:s') }}']">
                                            <span class="ml-2">
                                                {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }}
                                            </span>
                                        </label>  
                                    </div>
                                 @endfor
                            </td>
                        @endforeach
                        </div>
                    </tr>
              @endforeach
        </tbody>

    </table>

     <div>
        <button wire:click="saveSchedules" class="btn btn-primary">
            Guardar Horarios
        </button>
    </div>
  </div>
</div>

<script>
    function tblData() {
        return {
            schedules: @entangle('schedules'),
            apointment_duration: @entangle('apointment_duration'),
            intervals : @entangle('intervals'),
            days:@entangle('days'),

            inicio() {
                console.log('Componente Livewire schedule inicializado');
            },

            toggleHourBlock(indexDay, hourBlock, evenntChecked) {            
                console.log('Toggle hour block:', indexDay, hourBlock, evenntChecked);                  
                let hour = new Date(`1970-01-01T${hourBlock}`); 
                for(i=0; i<this.intervals; i++) {
                    let startTime = new Date(hour.getTime() + i * this.apointment_duration * 60000);                    
                    let formattedStartTime = startTime.toTimeString().split(' ')[0];
                    console.log( 'Formatted Start Time:++', indexDay, i, formattedStartTime );
                    this.schedules[indexDay][formattedStartTime] = evenntChecked;                    
                }                                                        
            },
            
            isHourBlockChecked(indexDay, hourBlock) {                            
                let hour = new Date(`1970-01-01T${hourBlock}`); 
                
                for(i=0; i<this.intervals; i++) {
                    let startTime = new Date(hour.getTime() + (i * this.apointment_duration * 60000))                    
                    let formattedStartTime = startTime.toTimeString().split(' ')[0];
                    
                    if( !this.schedules[indexDay][formattedStartTime] ) {
                        return false; // Si alguna hora no está marcada, el bloque no está completamente marcado
                    }                                       
                } 
                              
                return true; // Si todas las horas están marcadas, el bloque está completamente marcado
                
            },

            toggleFullHourBlock( hourBlock, checked) {
                Object.keys(this.days).forEach(indexDay => {
                    this.toggleHourBlock(indexDay, hourBlock, checked);
                });
            },

            isFullHourBlockChecked(hourBlock) {
                return Object.keys(this.days).every(indexDay => {
                    return this.isHourBlockChecked(indexDay, hourBlock);
                });
            }
        }
    }
</script>





