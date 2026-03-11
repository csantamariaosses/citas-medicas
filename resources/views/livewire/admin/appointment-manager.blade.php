<div x-data="citaData()" x-init="inicio()">
   <h3>Gestión de Citas</h3>
   <p>Aquí puedes gestionar las citas médicas, incluyendo la creación, edición y eliminación

   <div class="container">
      <p>Buscar disponibilidad</p>
      <p>Encuentra el horario disponible para una cita.</p>
       
        <P> <H4>SELECCIONAR HORARIO DE CITAS PARA</H4></P>
        <P>
            <SELECT  wire:model="patient->patient_id" class="form-control">
               @foreach($this->patients as $patient)
                  <option value="{{ $patient->patient_id }}">{{ $patient->name }}</option>
               @endforeach
            </SELECT>


        </P>

        <hr>
      <div class="row">
         <div class="col-sm">
               <label for="date">Selecciona una fecha:</label>
               <input type="date" id="date" class="form-control" wire:model="search.date">
               <div style="color: red">@error('search.date') {{ $message }} @enderror</div>
         </div>
         <div class="col-sm">
               <label for="hora">Selecciona una hora:</label><br>
               <select wire:model="search.hour" class="form-control">

                     @foreach($this->hourBlocks as $hourBlocks)
                        @php
                           // Formateo a string
                           $hour = $hourBlocks->format('H:i:s');  
                        @endphp                              
                        @for( $i=0; $i<$this->intervals; $i++ )
                              @php
                                 $startTime = $hourBlocks->copy()->addMinutes($i * $this->appointment_duration);
                                 $endTime = $startTime->copy()->addMinutes($this->appointment_duration);                                
                              @endphp
                              <option value="{{ $startTime->format('H:i:s') }}">{{ $startTime->format('H:i:s') }} - {{ $endTime->format('H:i:s') }}</option>
                        @endfor

                     @endforeach
               </select>
               <div style="color: red">@error('search.hour') {{ $message }} @enderror</div>
               
         </div>
         <div class="col-sm">
               <label for="doctor">Selecciona una especialidad:</label>
               <select class="form-control" wire:model="search.speciality_id">
                  <option value="">Selecciona una especialidad</option>
                  @foreach($this->specialities as $speciality)
                     <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                  @endforeach
               </select>
         </div>
         
         <div class="col-sm">
            <button class="btn btn-primary mt-4" @click="searchAvailability">Buscar</button>
            <button class="btn btn-primary mt-4" wire:click="searchAvailability">Buscar en Componente</button>
         </div>
      </div>

      <div class="row mt-4">
         <div class="col-9">

            @if( $appointment['date'])
               @if( $availability <> null and count($availability) > 0 )
                  <h4>Disponibilidad para:</h4>
                  <ul>
                     @foreach($availability as $slot)
                        <li>{{ $slot->doctor_id }} - {{ $slot->doctor }} : {{ $slot->speciality_id}} - {{ $slot->speciality}} - {{$appointment['date']}} - {{ $slot->start_time }} -  {{ $slot->end_time }} - {{$patient->patient_id}} - {{ $patient->name }}<button class="btn btn-primary ms-2" wire:click="guardarCita( '{{ $appointment['date']}} ', '{{ $slot->doctor_id}}', '{{$slot->speciality_id}}', '{{$slot->start_time }}', '{{$patient->patient_id}}' )">Seleccionar</button></li>
                     @endforeach
                  </ul>
               @else
                   
                  <p class="mt-5">No hay disponibilidad para la fecha y hora seleccionada.</p>
               @endif
            @endif
         </div>

         <div class="col-3">
                  @if( $resumen_cita )
                     <h4>Resumen de la cita</h4>
                     <p>Doctor: {{ $resumen_cita[0]->doctor_name }}</p>
                     <p>Paciente: {{ $resumen_cita[0]->paciente }}</p>
                     <p>Fecha: {{ $resumen_cita[0]->fecha }}</p>
                     <p>Hora inicio: {{ $resumen_cita[0]->hora_inicio }}</p>
                     <p>Hora fin: {{ $resumen_cita[0]->hora_fin }}</p>
                     
                  @endif
         </div>
      </div>


</div>

<script>
   function citaData() {
      return {
         search: @entangle('search'),

         selectedSchedules : @entangle('selectedSchedules').live,

         inicio() {
            console.log('Componente Livewire appointmentManager inicializado *****');
         },

         searchAvailability() {
            console.log("abc abc");
            console.log('Buscando disponibilidad para:', this.search);
         }
      }
   }
</script>
