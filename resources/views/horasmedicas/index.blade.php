@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')
<style>
   .contenedor-tabla {
  width: 100%;
  overflow-x: auto; /* Permite scroll horizontal si la tabla es muy ancha */
  overflow-y: auto; /* Permite scroll vertical si la tabla es muy alta */
  margin: 20px 0;
  height: 200px; /* Ajusta la altura según tus necesidades */
}

/* 2. Estilos básicos de la tabla */
table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

th {
  background-color: #f4f4f4;
}


.color-red {
    color: #ff0000;
}

.color-blue {
    color: #0000ff;
}

.color-green {
    color: #008000;
}
</style>

 <div class="row">
     <div class="col-12">
         <h3>HORAS MEDICAS - PACIENTE</h3>
         <p>Bienvenido {{ session('patientName') }} - patient_id: {{ session('patient_id') }}</p>
         <p style="color:blue;">Estas son sus horas médicas agendadas:</p>
         
    </div>
</div>
  

 <div class="row">
     <div class="col-10">
        <div class="contenedor-tabla">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cita ID</th>
                        <th>patient_id</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Doctor</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                        <th>Ver Detalle</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->patient_id }}</td>
                            <td>{{ $appointment->date->format('Y-m-d') }}</td>
                            <td>{{ $appointment->start_time->format('H:i') }}</td>
                            <td>{{ $appointment->doctor->user->name }}</td>
                            <td>{{ $appointment->doctor->speciality->name }}</td>
                            <td>
                                @if( $appointment->status == App\Enums\AppointmentEnum::SCHEDULED )
                                 <span class="color-green">{{ $appointment->status->label() }}</span></td>
                                @elseif( $appointment->status == App\Enums\AppointmentEnum::CANCELED )
                                 <span class="color-red">{{ $appointment->status->label() }}</span></td>
                                @elseif( $appointment->status == App\Enums\AppointmentEnum::COMPLETED )
                                 <span class="color-blue">{{ $appointment->status->label() }}</span></td>
                                @else
                                 <span>{{ $appointment->status->label() }}</span>                            
                                @endif
                            </td>
                            <td> 
                                <button type="button" class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#ModalDetalle-{{ $appointment->id }}"> Ver Detalle
                                </button>
                            </td>
                            <td>
                            @if( $appointment->status == App\Enums\AppointmentEnum::SCHEDULED )    
                            <button type="button" class="btn btn-danger "  data-bs-toggle="modal" data-bs-target="#Modal-{{ $appointment->id }}">
                                 Cancelar Cita
                            </button>
                            @else
                            <span style="color:gray;">No disponibles</span>
                            @endif
                           </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
          
     </div>
 </div>
<hr>
 <div class="row">
        <div class="col-8">
              <div class="card">
                    <div class="card-header">
                          AGENDA DOCTORES    - Patient_Id: {{ session('patient_id') }} - PatientName: {{ session('patientName')}}<br><br>
                          <p style="color:blue;">Para agendar nuevas horas medicas, seleccione la especialidad y luego el doctor. Luego se mostrarán las horas disponibles para agendar su hora médica.</p>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                     <form name="frmEspecialidad" action="{{ route('horasmedicas.doctores') }}" method="POST">
                                      @csrf
                                      <select name="especialidad" id="especialidad">
                                            <option value="0">Seleccione Especialidad</option>
                                            @foreach($especialidades as $especialidad)
                                                <option value="{{ $especialidad->id }}">{{ $especialidad->id }}-{{ $especialidad->name }}</option>
                                            @endforeach
                                      </select>
                                      @error('especialidad')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                      <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
                                      <button id="miBoton" type="submit" class="btn btn-primary" disabled>Buscar</button>
                                      </form>

                                      <span id="selectedEspecialidad"></span>
                                </div>
                                <div class="col-6">
                                     <form action="">
                                      @csrf
                                      <select name="doctor" id="doctor">
                                            <option value="0">Seleccione Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->id }} - {{ $doctor->user->name }}</option>
                                            @endforeach
                                      </select>
                                       <button type="submit" class="btn btn-primary" >Buscar</button>
                                      </form>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                          <a href="#" class="btn btn-primary">Go somewhere</a>  
                    </div>

              </div>
        </div>
    </div>


<!-- Modal -->
@foreach($appointments as $appointment)
<div class="modal fade" id="Modal-{{ $appointment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancelación Cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        Esta seguro que desea anular la hora médica? Esta acción no se puede deshacer.
        {{ $appointment->id }}
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form action="{{ route('horasmedicas.cancelar') }}" method="POST">
            <input type="hidden" name="appointment_id" id="appointment_id" value="{{ $appointment->id }}">
            @csrf
           <button type="submit" class="btn btn-primary" >Save changes</button>
        </form>
      </div>
    </div> 
    </div>
  </div>
@endforeach
   

<!-- Modal Detalle -->
@foreach($appointments as $appointment)
<div class="modal fade" id="ModalDetalle-{{ $appointment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle Cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p><strong>Id:</strong> {{ $appointment->id }}</p>
        <p><strong>Fecha:</strong> {{ $appointment->date }}</p>
        <p><strong>Hora:</strong> {{ $appointment->start_time }}</p>
        <p><strong>Especialidad:</strong> {{ $appointment->doctor->speciality->name }}</p>
        <p><strong>Médico:</strong> {{ $appointment->doctor->user->name }}</p>
        <p><strong>Paciente:</strong> {{ $appointment->patient->user->name }}</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div> 
    </div>
  </div>
@endforeach

   
    <script>
        document.getElementById('especialidad').addEventListener('change', function() {
            const select = document.getElementById('especialidad');
            const boton = document.getElementById('miBoton');
            if( select.value > 0 ) {
                boton.disabled = false;
            } else {
                boton.disabled = true;
            }

        });
    </script>


@endsection
