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

               <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home">Citas En Curso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu1">Schedules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu2">Calendario de Citas</a>
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
                    <div class="tab-pane container fade" id="menu2">
                    Aqui componente calendario<br>
                    {{ session('doctor_id') }}<br>
                    {{ $doctor->user->name }}<br>
                    <a href="{{ route('doctor.cita.calendar', $doctor->id) }}" class="btn btn-primary" target="_blank">Calendario</a>
                     <div x-data="dataCalendar()">
                     <div x-ref="calendar"> </div> 
       
    
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



      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script>

      function dataCalendar() {
            console.log("Iniciando calendario");
            const doctor_id = @json(session('doctor_id'));
            console.log("Valor de la sesión (doctor_id):", doctor_id);

            let salida;
            let citas=[];
            let appoints=[];

            let patient_id =  $( "#patient_id" ).val();
            let patientName =  $( "#patientName" ).val();
            //let doctor_id =  $( "#doctor_id" ).val();
            let doctorName =  $( "#doctorName" ).val();
            
            let specialityName =  $( "#specialityName").val();

            console.log("Doctor_Id:" + doctor_id);
            console.log("Doctor:" + doctorName);
            console.log("Paciente:" + patientName);
            console.log("Especialidad:" + specialityName);

            $( "#modalDoctorName").val(doctorName);
            $( "#modalPatientName").val( patientName );
            $( "#modalSpecialityName").val( specialityName );


            
            // GENERA TABLA FECHAPOSDIA
            generaTablaFechaPosDia();


            //let diasSeleccionados = [1, 3];
            let now = new Date();
            let year =  now.getYear() + 1900;
            let month = now.getMonth(); // Abril (0-indexado, 0 = Enero,
        
            generaDiasMesEnCurso = generarDiasMes(year, month);
                                          
            return {
                init(){
                  var calendarEl = this.$refs.calendar;
                  var calendar = new FullCalendar.Calendar(calendarEl, {
                      headerToolbar:{
                        left:'prev,next today',
                        center:'title',
                        right:'dayGridMonth, timeGridWeek, timeGridDay, listWeek'
                      },

                      locale:'es',

                      buttonText:{
                        today:'Hoy',
                        month:'Mes',
                        week:'Semana',
                        day:'Dia',
                        list:'Lista'
                      },

                      allDayText: 'Todo el dia',
                      noEventsText: 'No hay eventos para mostrar',

                      slotDuration: '00:15:00',   // Duración de cada intervalo de tiempo en la vista de cuadrícula de tiempo (timeGrid)
                      initialView: 'timeGridWeek',  // Vista Inicial semana en horas

                      slotMinTime: "{{ config('schedules.start_time') }}", // desde el archivo config/schedules.php
                      slotMaxTime: "{{ config('schedules.end_time') }}",   // desde el archivo config/schedules.php

                       eventTimeFormat: {           // Formato de hora en los eventos
                          hour: '2-digit',
                          minute: '2-digit',
                          meridiem: false,           // Usa formato de 24 horas (true para AM/PM)
                          omitZeroMinute: false      // Muestra :00 en punto en lugar de ocultarlo
                      },
                    

                      events: [
                                <?php
                                use Illuminate\Support\Facades\DB;       
                                
                                // Disponibles
                                $sql =       "  select app.id, app.patient_id, sch.doctor_id, fecha.fecha, fecha.day_of_week, sch.start_time, sch.end_time, app.date,";
                                $sql = $sql ." 'Disponible' as estado, '#669999' as color,  concat(fecha.fecha,'T', sch.start_time) as fechastart,  ";
                                $sql = $sql ."  concat(fecha.fecha,'T', sch.end_time) as fechaend , userdoc.name as doctorName, userpat.name as patientName , spec.name as specialityName  ";
                                $sql = $sql ."  from fechaposdias fecha  ";
                                $sql = $sql ."  left join schedules sch on ( fecha.day_of_week = sch.day_of_week )  ";
                                $sql = $sql ."  left join appointments app on ( fecha.fecha =  app.date and sch.start_time = app.start_time) ";
                                $sql = $sql ."  left join doctors doc on ( doc.id = sch.doctor_id )  ";
                                $sql = $sql ."  left join users userdoc on ( doc.user_id = userdoc.id )  ";
                                $sql = $sql ."  left join patients patdisp on ( app.patient_id = patdisp.id )  ";
                                $sql = $sql ."  left join users userpat on ( patdisp.user_id = userpat.id ) ";
                                $sql = $sql ."  left join specialities spec on ( doc.speciality_id = spec.id )  ";
                                $sql = $sql ."  where sch.doctor_id = ? ";
                                $sql = $sql ."  and  app.date is null  ";

                                $sql = $sql ." union ";

                                // Agendados
                                $sql = $sql ."   select app.id, app.patient_id, app.doctor_id, fecha.fecha, fecha.day_of_week, sch.start_time, sch.end_time, app.date, ";
                                $sql = $sql ." 'Agendado' as estado, ";
                                $sql = $sql ." '#a58d13' as color,  concat(fecha.fecha,'T', sch.start_time) as fechastart,  ";
                                $sql = $sql ."     concat(fecha.fecha,'T', sch.end_time) as fechaend,   ";
                                $sql = $sql ."     userdoc.name as doctorName, userpat.name as patientName , spec.name as specialityName ";  
                                $sql = $sql ."     from fechaposdias fecha  ";
                                $sql = $sql ."     left join schedules sch on ( fecha.day_of_week = sch.day_of_week )  ";
                                $sql = $sql ."     left join appointments app on ( fecha.fecha = app.date  and sch.start_time = app.start_time)  ";
                                $sql = $sql ."     left join doctors doc on ( doc.id = app.doctor_id )  ";
                                $sql = $sql ."     left join users userdoc on ( doc.user_id = userdoc.id ) ";  
                                $sql = $sql ."     left join patients pat on ( app.patient_id = pat.id )  ";
                                $sql = $sql ."     left join users userpat on ( pat.user_id = userpat.id ) "; 
                                $sql = $sql ."     left join specialities spec on ( doc.speciality_id = spec.id )  ";
                                $sql = $sql ."     where sch.doctor_id =   ? ";
                                $sql = $sql ."     and  sch.doctor_id = app.doctor_id  ";
                                $sql = $sql ."     and  app.id is not null ";
                                $sql = $sql ."     and  sch.id is not null  ";
                                $sql = $sql ."     and  app.status = 1 ";

                                $sql = $sql ." union ";

                                // Cancelados
                                $sql = $sql ." select app.id, app.patient_id, app.doctor_id, fecha.fecha, fecha.day_of_week, sch.start_time, sch.end_time, app.date,";
                                $sql = $sql ." 'Cancelado' as estado, 'rgb(16, 69, 69)' as color,  ";
                                $sql = $sql ." concat(fecha.fecha,'T', sch.start_time) as fechastart,  ";
                                $sql = $sql ." concat(fecha.fecha,'T', sch.end_time) as fechaend , userdoc.name as doctorName,";
                                $sql = $sql ." userpat.name as patientName , spec.name as specialityName ";
                                $sql = $sql ." from fechaposdias fecha  ";
                                $sql = $sql ." left join schedules sch on ( fecha.day_of_week = sch.day_of_week )  ";
                                $sql = $sql ." left join appointments app on ( fecha.fecha =  app.date and sch.start_time = app.start_time)  ";
                                $sql = $sql ." left join doctors doc on ( doc.id = app.doctor_id )  ";
                                $sql = $sql ." left join users userdoc on ( doc.user_id = userdoc.id )  ";
                                $sql = $sql ." left join patients patdisp on ( app.patient_id = patdisp.id )  ";
                                $sql = $sql ." left join users userpat on ( patdisp.user_id = userpat.id )  ";
                                $sql = $sql ." left join specialities spec on ( doc.speciality_id = spec.id )  ";
                                $sql = $sql ." where sch.doctor_id = ? ";
                                $sql = $sql ." and  app.date is not null ";  
                                $sql = $sql ." and  app.status =  3 ";

                                
                                $registros = DB::select( $sql, [session('doctor_id'), session('doctor_id') , session('doctor_id')   ] );             

                                foreach( $registros as $fila) {
                                ?>
                                    {
                                        'start': '<?php  echo $fila->fechastart;  ?>',
                                        'end': '<?php echo $fila->fechaend ?>',
                                        'title': '<?php echo $fila->estado ?>',
                                        'color': '<?php echo $fila->color ?>',
                                        'id': '<?php echo $fila->id ?>',
                                        extendedProps: {
                                            doctor_id: '<?php echo $fila->doctor_id ?>',
                                            doctor_name: '<?php echo $fila->doctorName ?>',
                                            specialityName: '<?php echo $fila->specialityName ?>',
                                            patient_id: '<?php echo $fila->patient_id ?>',
                                            patient_name: '<?php echo $fila->patientName ?>',
                                            status: '<?php echo $fila->estado ?>'
                                        }
                                            
                                    },
                                <?php
                                 }                                 
                                ?>                                                                              
                      ] ,

                      
                
                        selectAllow: function(selectInfo) {
                          // Deshabilitar si el día seleccionado es domingo
                          alert("selectAll:" + selectInfo.start.getDay());
                          //return selectInfo.start.getDay() !== 0;
                        },

                      
                      
                       dateClick: function(info) {
                          console.log("DtaClick");

                        },

                        
                        eventClick:function(info){

                              console.log("*****evento Click");

                              console.log('Id: ' + info.event.id);
                              console.log('Title: ' + info.event.title);

                              console.log("Fecha:" + info.event.start.toISOString().slice(0, 10)); // 2026-03-30
                              console.log('Start: ' + info.event.start);
                              
                              console.log("Hora:" + info.event.start.toString().split(' ')[4]  ); // 14:00:00
                              console.log("Medico:" + info.event.extendedProps.doctor_name); // 14:00:00
                              console.log("Paciente:" + info.event.extendedProps.patient_name); // 14:00:00

                              if( info.event.start < now ) {
                                  alert("La Fecha seleccionada es pasada");  
                              } else {
                                    let now = new Date();
                                    if( info.event.title == 'Disponible' ) {
                                        console.log("Status::" + info.event.status);

                                        $("#modalDoctorName").val( doctorName );
                                        $("#modalSpecialityName").val( info.event.extendedProps.specialityName );
                                        $("#modalPatientName").val( patientName );

                                        $("#modalFecha").val( info.event.start.toISOString().slice(0, 10));
                                        $("#modalStartTime").val( info.event.start.toString().split(' ')[4]  );

                                        $("#fecha").val( info.event.start.toISOString().slice(0, 10));                                        
                                        $("#startTime").val( info.event.start.toString().split(' ')[4]  );
                                        $("#modal").modal("show");      
                                    } 

                                    if( info.event.title == 'Agendado') {
                                        console.log( "Agendado");
                                        console.log( info.event.id);
                                        $("#modalCitaIdAg").val( info.event.id );
                                        $("#modalCitaIdAgHidden").val( info.event.id );
                                        $("#modalDoctorIdAgHidden").val( info.event.extendedProps.doctor_id );
                                        $("#modalPatientIdAgHidden").val( info.event.extendedProps.patient_id );
                                        $("#modalFechaStartAgHidden").val( info.event.start.toISOString().slice(0, 10) );
                                        $("#modalFechaHoraStartAgHidden").val( info.event.start.toString().split(' ')[4] );

                                        $("#fechaAg").val( info.event.start.toISOString().slice(0, 10));
                                        $("#start_timeAg").val( info.event.start.toString().split(' ')[4] );
                                        $("#modalDoctorIdAg").val( info.event.extendedProps.doctor_id);
                                        $("#modalDoctorNameAg").val( info.event.extendedProps.doctor_name);
                                        $("#modalPatientIdAg").val( info.event.extendedProps.patient_id);
                                        $("#modalPatientNameAg").val( info.event.extendedProps.patient_name);
                                        $("#modalSpecialityNameAg").val( info.event.extendedProps.specialityName );

                                        $("#fechaModal").val( info.event.start.toISOString().slice(0, 10));
                                        $("#startTimeModal").val( info.event.start.toString().split(' ')[4]  );

                                        $("#modalCitaIdConfirmCancelHidden").val( info.event.id );
                                        $("#modalDoctorIdConfirmCancelHidden").val( info.event.extendedProps.doctor_id );

                                        $("#modalAgendado").modal("show");    
                                    }                                              
                                    
                                     if( info.event.title == 'Cancelado') {
                                        console.log( "Cancelada");
                                        console.log( info.event.id);

                                        $("#modalCitaIdUpdate").val( info.event.id ); 
                                        $("#modalCitaIdUpdateHidden").val( info.event.id );

                                        $("#modalDoctorIdUpdateHidden").val( info.event.extendedProps.doctor_id );
                                        $("#modalDoctorNameUpdateHidden").val( info.event.extendedProps.doctor_name );

                                        $("#modalDoctorIdUpdate").val( info.event.extendedProps.doctor_id );
                                        $("#modalDoctorIdUpdateHidden").val( info.event.extendedProps.doctor_id );

                                        $("#modalDoctorNameUpdate").val( info.event.extendedProps.doctor_name );
                                        $("#modalSpecialityNameUpdate").val( info.event.extendedProps.specialityName );
                                        
                                        $("#modalPatientIdUpdate").val( info.event.extendedProps.patient_id );
                                        $("#modalPatientIdUpdateHidden").val( info.event.extendedProps.patient_id );

                                        $("#modalPatientNameUpdateHidden").val( info.event.extendedProps.patient_name );

                                        $("#modalFechaStartUpdate").val( info.event.start.toISOString().slice(0, 10) );
                                        $("#modalFechaStartUpdateHidden").val( info.event.start.toISOString().slice(0, 10) );

                                        $("#modalHoraStartUpdate").val( info.event.start.toString().split(' ')[4] );
                                        $("#modalHoraStartUpdateHidden").val( info.event.start.toString().split(' ')[4] );

                                        $("#modalUpdateAgenda").modal("show");    
                                    }                                              
                              }                                                                                         
                        },
                        hiddenDays: [ 0 ]
                        

                   });
                   
                  calendar.render();
                   // alert("Calendario cargado");
                  }
             }
        }

    
          function generarDiasMes(year, month){
              let dates = [];
              let date = new Date(year, month, 1); // Primer día del mes
              //console.log( "Generar dias del mes para el calendario: " + date.toISOString().slice(0, 10) );
              // Mientras sigamos en el mismo mes
              while (date.getMonth() === month) {
                  // Formatear a YYYY-MM-DD
                  let isoDate = date.toISOString().slice(0, 10);
                  let diaSemana = date.getDay();
                  let dia = {
                      fecha: isoDate,
                      diaSemana: diaSemana
                  };
                  dates.push( dia );                 
                  // Pasar al siguiente día
                  date.setDate(date.getDate() + 1); 
              }
              return dates;
          }

       



            function generaTablaFechaPosDia() {
                axios.get('http://localhost:8080/api/generatablafechaposdia')
                        .then(function (response) {   
                            //console.log( response.data);
                            //return rsponse.data;                                                 
                        })
                        .catch( function( err) {
                              console.log('Error::', err.message);
                        });
            }

    </script>     
@endsection


