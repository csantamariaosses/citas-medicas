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
</style>
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Doctor Dashboard</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-10 offset-2">  
     Nombre:{{ session('doctorName') }} - Role: {{ session('role') }} - Id:{{ session('user_id') }} - Email:{{ session('user_email') }}
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2">  
           <table class="table table-striped">
            <thead>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Estado Cita</th>
                <th>Acciones</th>
            </thead>
            @foreach($citas as $cita)

            <tbody>
                <tr>
                <td>{{ Illuminate\Support\Arr::first( explode( ' ', $cita->date ) )  }}</td>
                <td>{{ Illuminate\Support\Arr::last( explode( ' ', $cita->start_time ) ) }}</td>
                <td>{{ $cita->patient->user->name }}</td>
                <td>    @if( $cita->status == App\Enums\AppointmentEnum::SCHEDULED )
                            <span class="color-green">{{ $cita->status->label() }}</span></td>
                        @elseif( $cita->status == App\Enums\AppointmentEnum::CANCELED )
                            <span class="color-red">{{ $cita->status->label() }}</span></td>
                        @elseif( $cita->status == App\Enums\AppointmentEnum::COMPLETED )
                            <span class="color-blue">{{ $cita->status->label() }}</span></td>
                        @elseif( $cita->status == App\Enums\AppointmentEnum::EN_PROCESO )
                            <span class="color-yellow">{{ $cita->status->label() }}</span></td>
                        @endif
                </td>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal-{{ $cita->id }}">
                         Gestionar
                    </button>
                    <a href="{{ route('doctor.cita.show', $cita->id) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('doctor.cita.gestionar', $cita->id) }}" class="btn btn-primary">Gestionar</a>
                    <form action="{{ route('doctor.cita.destroy', $cita->id) }}" 
                          method="POST" 
                          style="display:inline;"
                          class="delete-form">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $cita->id }}">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
                <tr>      
            </tbody>
            @endforeach
           </table>              
        </div>
    </div>

    <!-- Estructura del Modal -->
    @foreach($citas as $cita)
    <div class="modal fade" id="miModal-{{ $cita->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Gestionar Consulta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('doctor.cita.update') }}" method="POST">
                @csrf
                <input type="hidden" name="cita_id" value="{{ $cita->id }}">
                Cita: {{ $cita->id }}<br>
                Paciente: {{ $cita->patient->user->name }}<br>
                Fecha: {{ Illuminate\Support\Arr::first( explode( ' ', $cita->date ) )  }}<br>
                Hora: {{ Illuminate\Support\Arr::last( explode( ' ', $cita->start_time ) ) }} <br>
                Diagnostico: <textarea name="diagnostic" class="form-control"></textarea><br>
                Tratamiento: <textarea name="treatment" class="form-control"></textarea><br>
                Notas: <textarea name="notes" class="form-control"></textarea><br>
                Prescription: <textarea name="prescriptions" class="form-control"></textarea><br><br>
                Estado de la cita: {{ $cita->status }}
                <select name="status" class="form-control">
                    @if( $cita->status == App\Enums\AppointmentEnum::SCHEDULED )
                        <option value="{{ App\Enums\AppointmentEnum::SCHEDULED }}" selected>Agendada</option>
                    @else 
                        <option value="{{ App\Enums\AppointmentEnum::SCHEDULED }}">Agendada</option>
                    @endif

                    @if( $cita->status == App\Enums\AppointmentEnum::COMPLETED )
                        <option value="{{ App\Enums\AppointmentEnum::COMPLETED }}" selected>Terminada</option>
                    @else
                        <option value="{{ App\Enums\AppointmentEnum::COMPLETED }}" >Terminada</option>
                    @endif

                    @if( $cita->status == App\Enums\AppointmentEnum::CANCELED )
                        <option value="{{ App\Enums\AppointmentEnum::CANCELED }}" selected>Cancelada</option>
                    @else
                        <option value="{{ App\Enums\AppointmentEnum::CANCELED }}" >Cancelada</option>
                    @endif

                    @if( $cita->status == App\Enums\AppointmentEnum::EN_PROCESO )
                        <option value="{{ App\Enums\AppointmentEnum::EN_PROCESO }}" selected>En Proceso</option>
                    @else
                        <option value="{{ App\Enums\AppointmentEnum::EN_PROCESO }}" >En Proceso</option>
                    @endif
                    
                </select><br><br>
                <input type="hidden" name="id" value="{{ $cita->id }}">
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


