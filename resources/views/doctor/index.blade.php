@extends('layouts.app')

@section('menu')
  @include('menudoctor')  
@endsection

@section('content')
<style>
    .color-green {
        color: #008000;
    }
    .color-red {
        color: #ff0000;
    }
    .color-blue {
        color: #0000ff;
    }
    .color-orange {
        color: #ffa500;
    }
    .color-brown {
        color: #97660a;
    }
</style>

    <div class="container">
        <div class="row">
            <div class="col-10 offset-2">  
              <h3>Gestión de Citas Médicas</h3>
            </div>
        </div>
        <HR>
        <div class="row">
            <div class="col-10">
               AQUI COMPONENTE DE TABS
               <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home">Citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu1">Schedules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu2">Menu 2</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane container active" id="home">Contenido menu Home
                       <div>
                    <div class="row">
                        <div class="col-8 offset-2">  
                        <table class="table table-striped">
                                <thead>
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Estado Cita</th>
                                    <th>Acciones</th>
                                </thead>
                                @foreach($appointments  as $appointment)

                                <tbody>
                                    <tr>
                                    <td>{{ $appointment->id }}</td>
                                    <td>{{ Illuminate\Support\Arr::first( explode( ' ', $appointment->date ) )  }}</td>
                                    <td>{{ Illuminate\Support\Arr::last( explode( ' ', $appointment->start_time ) ) }}</td>
                                    <td>{{ $appointment->patient->user->name }}</td>
                                    <td>    @if( $appointment->status == App\Enums\AppointmentEnum::SCHEDULED )
                                                <span class="color-green">{{ $appointment->status->label() }}</span></td>
                                            @elseif( $appointment->status == App\Enums\AppointmentEnum::CANCELED )
                                                <span class="color-red">{{ $appointment->status->label() }}</span></td>
                                            @elseif( $appointment->status == App\Enums\AppointmentEnum::COMPLETED )
                                                <span class="color-blue">{{ $appointment->status->label() }}</span></td>
                                            @elseif( $appointment->status == App\Enums\AppointmentEnum::EN_PROCESO )
                                                <span class="color-brown">{{ $appointment->status->label() }}</span></td>
                                            @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal-{{ $appointment->id }}">
                                            Ver / Gestionar
                                        </button>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModalHistorial-{{ $appointment->id }}">
                                            Historial
                                        </button>
                                    </td>
                                    <tr>      
                                </tbody>
                                @endforeach
                                            </table>              
                                        </div> <!-- col-8 offset-2 -->
                                    </div> <!-- row -->
                                </div> <!-- div -->
                    
                    </div>
                    <div class="tab-pane container fade" id="menu1">                       
                      SCHedule
                      {{ session('doctor_id') }}
                      {{ $doctor->user->name }}
                      @livewire('admin.schedule-manager', ['doctor' => $doctor]) 


                    </div>
                    <div class="tab-pane container fade" id="menu2">Contenido menu 2</div>
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

            @switch ($appointment->status) 
                @case(App\Enums\AppointmentEnum::SCHEDULED)
                    <span class="badge bg-success">Agendada</span>
                    @break
                @case(App\Enums\AppointmentEnum::COMPLETED)
                    <span class="badge bg-primary">Terminada</span>
                    @break
                @case(App\Enums\AppointmentEnum::CANCELED)
                    <span class="badge bg-danger">Cancelada</span>
                    @break
                @case(App\Enums\AppointmentEnum::EN_PROCESO)
                    <span class="badge bg-warning">En Proceso</span>
                    @break
            @endswitch
            

            <form action="{{ route('doctor.cita.updateCita') }}" method="POST">
                @csrf
                <input type="hidden" name="cita_id" value="{{ $appointment->id }}">
                Cita: {{ $appointment->id }}<br>
                Paciente: {{ $appointment->patient->user->name }}<br>
                Fecha Nac.: {{ $appointment->patient->birth_date }}<br>
                Edad:{{ \Carbon\Carbon::parse($appointment->patient->birth_date)->age }} <br>
                Fecha: {{ Illuminate\Support\Arr::first( explode( ' ', $appointment->date ) )  }}<br>
                Hora: {{ Illuminate\Support\Arr::last( explode( ' ', $appointment->start_time ) ) }} <br>
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
                <button type="submit" class="btn btn-primary">Guardar</button> 
                <a href="{{ route('doctor.cita.pdf', ['id' => $appointment->id]) }}" class="btn btn-primary" target="_blank">PDF/Imprimir (DomPDF)</a>
                <a href="{{ route('doctor.citaSpatie.pdf') }}" class="btn btn-primary" target="_blank">PDF/Imprimir (Spatie)</a>
               
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    @endforeach

     <!-- Estructura del Modal -->
    @foreach($appointments as $appointment)
    <div class="modal fade" id="miModalHistorial-{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Historial Paciente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('doctor.cita.updateCita') }}" method="POST">
                @csrf
                <input type="hidden" name="cita_id" value="{{ $appointment->id }}">
                Paciente: {{ $appointment->patient->user->name }}<br>
                Fecha Nac. <span>{{ $appointment->patient->user->name}}</span>
                <hr>
                Tipo de Sangre: {{ $appointment->patient->bloodType->name }} <br>
                Alergias: <textarea name="allergies" class="form-control">{{ $appointment->patient->allergies }}</textarea> <br>
                Enfermedades Crónicas: <textarea name="chronicDiseases" class="form-control">{{ $appointment->patient->chronics_conditions }}</textarea> <br><br>
                 <hr>
                <table class="table table-striped">
                <tr><th>Fecha</th><th>Diagnostico</th><th>Tratamiento</th><th>Prescripcion</th><th>Notas</th></tr>
                <tr><td><span>{{ $appointment->consultation ? substr($appointment->consultation->created_at,0,10) : '' }}</span></td>
                    <td><textarea name="diagnosticoTbl" cols="10" rows="3">{{ $appointment->consultation ? $appointment->consultation->diagnostic : ''  }}</textarea></td>
                    <td><textarea name="tratamientoTbl" cols="10" rows="3">{{ $appointment->consultation ? $appointment->consultation->treatment : ''  }}</textarea></td>
                    <td><textarea name="prescriocionTbl" cols="10" rows="3">{{ $appointment->consultation ? $appointment->consultation->prescriptions : ''  }}</textarea></td>
                    <td><textarea name="notasTbl" cols="10" rows="3">{{ $appointment->consultation ? $appointment->consultation->notes : ''  }}</textarea></td>

                </table>

                <input type="hidden" name="id" value="{{ $appointment->id }}">
                <button type="submit" class="btn btn-primary">Guardar</button> 
            </form>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>
    @endforeach
@endsection


