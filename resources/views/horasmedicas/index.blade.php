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
                        AGENDA DOCTORES  JQUERY
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <p>Aqui Componente de la Especialidad</p>
                            <!-- <form name="selectDoctor" action="{{ route('horasmedicas.showcalendar') }}" method="post"> -->
                            <form name="selectDoctor" action="{{ route('agendapatient.showcalendar') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="especialidades">Especialidades:</label>
                                            <select name="speciality" id="speciality" class="form-control">
                                                <option value="">Seleccione una especialidad</option>
                                                @foreach($specialities as $speciality)
                                                    <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- Cierre de la fila -->
                                <div class="row">
                                <div class="col-6">
                                        <!-- Select Anidado de Especialidad y Doctores -->
                                        <div class="form-group">
                                            <label for="doctor">Doctor:</label>
                                            <select name="doctor" id="doctor" class="form-control">
                                                <option value="">Seleccione un doctor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> <!-- Cierre de la fila -->
                                <div class="row">
                                <div class="col-3 d-grid">
                                    <button type="submit" class="btn btn-primary btn-l"  disabled>Consultar</button>
                                </div>
                            </form>
                            
                        </div>
                        <div class="col-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <HR>

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
        <p><strong>Paciente:</strong> {{ $appointment->patient->user->name }}</p>
        <hr>
        <p><strong>Fecha:</strong> {{ substr($appointment->date, 0, 10) }}</p>
        <p><strong>Hora:</strong> {{ substr($appointment->start_time, 11,10) }}</p>
        <p><strong>Especialidad:</strong> {{ $appointment->doctor->speciality->name }}</p>
        <p><strong>Médico:</strong> {{ $appointment->doctor->user->name }}</p>
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="{{ route('horasmedicas.imprimir', ['id' => $appointment->id]) }}" class="btn btn-primary" target="_blank">Imprimir</a>
      </div>
    </div> 
    </div>
  </div>
@endforeach

  <!-- Cargar jQuery -->
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
    integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
</script>


<script>
$(document).ready(function () {
    $('#doctor').val(); // Inicializar el valor del select de doctores como vacío
    console.log('Valor inicial del select de doctores:', $('#doctor').val()); // Verificar el valor inicial del select de doctores
    $('#speciality').on('change', function () {
        console.log('Valor seleccionado del select de especialidades:', $(this).val()); // Verificar el valor seleccionado del select de especialidades
        var specialityId = $(this).val();
        console.log('Valor de specialityId:', specialityId); // Verificar el valor de specialityId
        
        // Vaciar y deshabilitar el segundo select si no hay selección
        $('#doctor').empty().append('<option value="">Seleccione un doctor</option>');
        
        if (specialityId) {
        console.log('Haciendo solicitud AJAX para la especialidad ID:', specialityId); // Verificar la especialidad seleccionada antes de la solicitud AJAX
            $.ajax({
                url: '/api/doctores/' + specialityId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Recorrer los datos recibidos y agregarlos al select
                    $.each(data, function (key, value) {
                    console.log('Agregando doctor al select:', value); // Verificar cada doctor agregado al select
                        $('#doctor').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function () {
                    alert('Error al cargar los doctores.');
                }
            });
        }
    });

    $('#doctor').on('change', function () {
        var doctorId = $(this).val();
        console.log('Valor seleccionado del select de doctores:', doctorId); // Verificar el valor seleccionado del select de doctores
        if (doctorId) {
            $('button[type="submit"]').prop('disabled', false);
        } else {
            $('button[type="submit"]').prop('disabled', true);
        }
    });
});

</script>
@endsection()
