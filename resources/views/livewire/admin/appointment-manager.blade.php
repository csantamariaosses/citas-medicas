<div x-data="citaData()" x-init="inicio()">
   <h3>Gestión de Citas</h3>
   <p>Aquí puedes gestionar las citas médicas, incluyendo la creación, edición y eliminación

   <div class="container">
      <p>Buscar disponibilidad</p>
      <p>Encuentra el horario disponible para una cita.</p>


      <div class="row">
         <div class="col-sm">
               <label for="date">Selecciona una fecha: {{ $this->hola }}</label>
               <input type="date" id="date" class="form-control" wire:model="search.date">
               <div style="color: red">@error('search.date') {{ $message }} @enderror</div>
         </div>
         <div class="col-sm">
               <label for="hora">Selecciona una hora:</label><br>
               <select wire:model="search.hour" class="form-control">
                  @foreach($this->hourBlocks as $hourBlock)
                     <option value="{{ $hourBlock->format('H:i:s') }}">{{ $hourBlock->copy()->format('H:i') }} - {{ $hourBlock->addMinutes(config('schedules.apointment_duration'))->format('H:i') }} </option>
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
            <button class="btn btn-primary mt-4" @click="searchAvailability" wire:click="searchAvailabilityComp">Buscar</button>
         </div>
      </div>

   </div>


</div>

<script>
   function citaData() {
      return {
         search: @entangle('search'),

         inicio() {
            console.log('Componente Livewire appointmentManager inicializado');
         },

         searchAvailability() {
            console.log('Buscando disponibilidad para:', this.search);
            /*
           $this->validate([
               'search.date' => 'required|date|after_or_equal:today',
               'search.hour' => [
                     'required',
                     'date_format:H:i:s',
                     Rule::when( $this->search['date'] === now()->format('Y-m-d') , [
                        after_or_equal:now()->format('H:i:s')
                     ])
               ],
               'search.speciality_id' => 'required|exists:specialities,id',   
           ]);
           */
           
         }
      }
   }
</script>
