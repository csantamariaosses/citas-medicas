<div>
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
</div>
