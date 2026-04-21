@section('menu')
  @include('menuadmin')
@endsection

@section('content')
    <div>
         <p>Editar cita</p>
         <p>Editando la cita para:</p>
         <p>
              <span>Pacient: {{ $resumen_cita[0]->patient_name }}</span><br>
          </p>
         <div class="row">
             <div class="col-9">
             <label for="date">Fecha:</label>
             <input type="date" id="date" wire:model="appointment.date" class="form-control">
         </div>
          <div class="col-3">
              <label for="time">Hora:</label>
              <input type="time" id="time" wire:model="appointment.time" class="form-control">  
          </div>
          

    </div>
@endsection