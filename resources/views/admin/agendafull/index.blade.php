@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')
    <h3>AGENDA FULL</h3>

    <div class="row">
        <div class="col-8">
              <div class="card">
                    <div class="card-header">
                          AGENDA FULL
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-11">
                                    <table class="table tble-striped">
                                        <thead>
                                            <tr>
                                                <th>App ID</th>
                                                <th>Date</th>
                                                <th>Start Time</th>
                                                <th>Doctor</th>
                                                <th>Patient</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ substr($appointment->date, 0, 10) }}</td>
                                            <td>{{ substr($appointment->start_time, 12, 8) }}</td>
                                            <td>{{ $appointment->doctor->user->name }}</td>
                                            <td>{{ $appointment->patient->user->name }}</td>
                                            <td>{{ $appointment->status->label() }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal-{{ $appointment->id }}">
                         Ver
                    </button>
                                                
                                        </tr>
                                    @endforeach
                                    </table>

                                </div>
                        
                            </div>
                    </div>
                </div>
        </div>
    </div>



    <!-- Estructura del Modal -->
    @foreach($appointments as $appointment)
    <div class="modal fade" id="miModal-{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Gestion de la  Consulta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('doctor.cita.update') }}" method="POST">
                @csrf
                <input type="hidden" name="cita_id" value="{{ $appointment->id }}">
                Cita: {{ $appointment->id }}<br>
                Paciente: {{ $appointment->patient->user->name }}<br>
                Fecha: {{ Illuminate\Support\Arr::first( explode( ' ', $appointment->date ) )  }}<br>
                Hora: {{ Illuminate\Support\Arr::last( explode( ' ', $appointment->start_time ) ) }} <br>
                Medico: {{ $appointment->doctor->user->name }} <br>
                <hr>
                Tipo de Sangre: {{ $appointment->patient->bloodType->name }} <br>
                Alergias: <textarea name="allergies" class="form-control">{{ $appointment->patient->allergies }}</textarea> <br>
                Enfermedades Crónicas: <textarea name="chronicDiseases" class="form-control">{{ $appointment->patient->chronics_conditions }}</textarea> <br><br>
                <hr>
                Diagnostico: <textarea name="diagnostic" class="form-control">{{ $appointment->consultation ? $appointment->consultation->diagnostic : '' }}</textarea><br>
                Tratamiento: <textarea name="treatment" class="form-control">{{ $appointment->consultation ? $appointment->consultation->treatment : '' }}</textarea><br>
                Prescription: <textarea name="prescriptions" class="form-control">{{ $appointment->consultation ? $appointment->consultation->prescriptions : '' }}</textarea><br><br>
                Notas: <textarea name="notes" class="form-control">{{ $appointment->consultation ? $appointment->consultation->notes : '' }}</textarea><br>
                Estado de la cita: {{ $appointment->status }}
               
                
                <select name="status" class="form-control">
                    @if( $appointment->status == App\Enums\AppointmentEnum::SCHEDULED )
                        <option value="{{ App\Enums\AppointmentEnum::SCHEDULED }}" selected>Agendada</option>
                    @else 
                        <option value="{{ App\Enums\AppointmentEnum::SCHEDULED }}">Agendada</option>
                    @endif

                    @if( $appointment->status == App\Enums\AppointmentEnum::COMPLETED )
                        <option value="{{ App\Enums\AppointmentEnum::COMPLETED }}" selected>Terminada</option>
                    @else
                        <option value="{{ App\Enums\AppointmentEnum::COMPLETED }}" >Terminada</option>
                    @endif

                    @if( $appointment->status == App\Enums\AppointmentEnum::CANCELED )
                        <option value="{{ App\Enums\AppointmentEnum::CANCELED }}" selected>Cancelada</option>
                    @else
                        <option value="{{ App\Enums\AppointmentEnum::CANCELED }}" >Cancelada</option>
                    @endif

                    @if( $appointment->status == App\Enums\AppointmentEnum::EN_PROCESO )
                        <option value="{{ App\Enums\AppointmentEnum::EN_PROCESO }}" selected>En Proceso</option>
                    @else
                        <option value="{{ App\Enums\AppointmentEnum::EN_PROCESO }}" >En Proceso</option>
                    @endif
                    
                </select><br><br>
                <input type="hidden" name="id" value="{{ $appointment->id }}">
                <button type="submit" class="btn btn-primary" disabled>Guardar</button> 
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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