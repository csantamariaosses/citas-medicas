@extends('layouts.app')

@section('menu')
  @include('menu')  
@endsection

@section('content')
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Calendar</h3>
        </div>
    </div>

    <div class="row">
        <div x-data="dataCalendar()">
            <div x-ref="calendar"> </div> 
        </div>
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

                      slotDuration: '00:15:00',
                      initialView: 'timeGridWeek',
                      slotMinTime: "{{ config('schedules.start_time') }}",
                      slotMaxTime: "{{ config('schedules.end_time') }}",

                      

                      events:{
                        url:"{{ route('api.appointments.index') }}",
                        failure: function() {
                          alert("Ocurrio un error al cargar los eventos");
                        }
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


