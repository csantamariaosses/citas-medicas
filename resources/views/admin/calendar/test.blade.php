@extends('layouts.app')

@section('menu')
  @include('menu')  
@endsection

@section('content')
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Calendar Test</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-2">

        </div>

        <div class="col-8">
          <div x-data="dataCalendar()">
              <div x-ref="calendar"> </div> 
          </div>
        </div>
        <div class="col-2">
          ...
        </div>

    </div>

        <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ route('prueba.testSave') }}" method="POST">
              @csrf

            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
              <div class="modal-body">
                  <label>Doctor:</label>
                  <select class="form-select" id="doctorSelect" name="doctorSelect">
                      <option value="">Seleccione un doctor</option>
                      @foreach($doctors as $doctor)
                          <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                      @endforeach
                  </select>

                  <label>Paciente:</label>
                  <select class="form-select" id="patientSelect" name="patientSelect">
                        <option value="">Seleccione un Paciente</option>
                      @foreach($patients as $patient)
                          <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                      @endforeach
                  </select>

                  <label>Fecha:</label>
                  <input type="text" class="form-control" id="date" name="date" readonly>
                  <label>Evento</label>
                  <input type="text" class="form-control" id="eventInput">
                  <label>Hora Inicio</label>
                  <input type="text" class="form-control" id="start_time" name="start_time" readonly>
                  <label>Hora Fin:::</label>
                  <input type="text" class="form-control" id="end_time" name="end_time" readonly>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
          </div>
            <input type="hidden" name="duration" value="15" id="duration">    
            <input type="hidden" name="doctor_id" value="1" id="doctor_id">
            <input type="hidden" name="patient_id" value="1" id="patient_id">
          </form>
    </div>



      <!-- Muestra mensaje de alerta -->

    <script>
         function dataCalendar() {
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

                      slotDuration: '00:30:00',
                      initialView: 'timeGridWeek',
                      slotMinTime: "{{ config('schedules.start_time') }}",
                      slotMaxTime: "{{ config('schedules.end_time') }}",

                      events:[
                        {
                        url:"{{ route('api.appointments.index') }}",

                        
                        failure: function() {
                          alert("Ocurrio un error al cargar los eventos");
                        }
                        },
                        {
                            start: '2026-03-31T12:00:00',
                            end: '2026-03-31T13:00:00',
                            display: 'background',
                            color: '#ff9f9f', // Color rojo para indicar bloqueado
                            title: 'Almuerzo999',
                            eventTextColor: '#ff0000' // Color del texto del evento
                        }
                          
                      ],




                        selectAllow: function(selectInfo) {
                          // Deshabilitar si el día seleccionado es domingo
                          alert("selectAll:" + selectInfo.start.getDay());
                          //return selectInfo.start.getDay() !== 0;
                        },

                      
                      
                       dateClick: function(info) {
                            //console.log("dateClicked on: Almuerzo" + info.dateStr  ); // e.g., "2023-10-27"
                            let now = new Date();
          
                            if(  info.date > now  ){ // Evitar que se abra el modal para fechas pasadas
                                 $("#exampleModal").modal("show"); 
                              } else {     
                                alert("La Fecha seleccionada es pasada");                           //alert("No puedes seleccionar una fecha pasada");
                            }

                            $("#date").val(info.dateStr.substring(0, 10));  // 2026-03-30T14:00:00

                            console.log( "Info:" + info.date);

                            let fecha_inicio = new Date(info.dateStr);
                            let fecha_fin = new Date(info.dateStr);
                            console.log( "fecha_inicio:" ,fecha_inicio);

                            let  minutosAgregar = 15;
                            fecha_fin.setMinutes(fecha_inicio.getMinutes() + minutosAgregar);
                            console.log( "fecha_fin :" ,fecha_fin);

                            console.log("Hora Inicio:" + fecha_inicio.toISOString().slice(11, 19)); // 14:00:00
                                                     
                            $("#start_time").val(fecha_inicio.toTimeString({ hour12: false }).substring(0, 8));

                            $("#end_time").val(fecha_fin.toTimeString({ hour12: false }).substring(0, 8)  ); // 14:30:00

                            $("#eventInput").val('Ingresar Evento');
                            
                        },

                        
                        eventClick:function(info){

                             console.log("evento bloqueado");
                             //alert('Event: ' + info.dateStr);
                        },
                        hiddenDays: [ 0 ],

                        dayClick:function(info){
                          alert('dayClicked on: ' + info.dateStr  ); // e.g., "2023-10-27" 
                        }
                        

                   });
                   
                  calendar.render();
                    //alert("Calendario cargado");
                  }
             }
         }
    </script>  

    @if(session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif 

    @if(Session::has('success'))
      <script>
        Swal.fire({
                icon: 'success',
                title: 'Entrada registrada',
                html: '{{ Session::get('success') }}',
            })
      </script>
    @endif

@endsection


