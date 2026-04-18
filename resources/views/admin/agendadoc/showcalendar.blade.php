@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')
    <h3>SHOW CALENDAR </h3>
    <div class="row">

        <div class="col-2">
           ..

        </div>
         
        <div class="col-8">
            
            <input type="hidden" id="doctorName" value="{{ session('doctorName') }}">
            <input type="hidden" id="specialityName" value="{{ session('specialityName') }}">
            <input type="hidden" id="pacienteName" value="{{ session('paciente') }}">
                       
            doctor_id:{{ $doctor_id}} - doctorName: {{ session('doctorName') }}  - Especialidad : {{ session('specialityName') }} - 
            Patient_id:{{ session('patient_id') }} 
            PatientName:{{ session('patientName') }} 
          <div x-data="dataCalendar()">
              <div x-ref="calendar"> </div> 
          </div>
        </div>
        <div class="col-2">
          <div id="citas"></div>
        </div>
    </div>

     
   <!-- Modal -->
      <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="{{ route('agendadoc.confirmar') }}" method="POST">
          @csrf 
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Confirmación de Hora</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table>
                   <tr>
                      <th>Médico:</th><td><input type="text" id="modalDoctorName" name="modalDoctorName" disabled></td>
                    </tr>
                    <tr>
                      <th>Especialidad:</th><td><input type="text" id="modalSpecialityName" name="modalSpecialityName" value="{{ session('specialityName') }}" disabled></td>
                    </tr>
                    <tr>
                      <th>Paciente:</th><td><input type="text" id="modalPatientName" name="modalPatientName" value="{{ session('patientName') }}" disabled></td>
                    </tr>
                    <tr>
                        <th>Fecha:</th><td><input type="text" id="modalFecha" name="modalFecha" disabled></td>
                    </tr>
                    <tr>    
                        <th>Hora</th><td><input type="text" id="modalStartTime" name="modalStartTime" disabled></td>
                    </tr>
                                 
                </table>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
              <input type="hidden" id="patientName" name="patientName" value="{{ session('patientName') }}">
              <input type="hidden" id="doctor_id" name="doctor_id" value="{{ session('doctor_id') }}">
              <input type="hidden" id="doctorName" name="doctorName" value="{{ session('doctorName') }}">
              <input type="hidden" id="spetiality" name="spetiality" value="{{ session('spetiality') }}">
              <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">
              <input type="hidden" id="fecha" name="fecha">
              <input type="hidden" id="startTime" name="startTime">
        

              <input type="hidden" id="end_time" name="end_time">              
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
          </div>
        </div>
        </form>
      </div>


      <!-- Modal  Agendado-->
      <div class="modal fade" id="modalAgendado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="{{ route('agendadoc.confirmar') }}" method="POST">
          @csrf 
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Informacion de la Hora Medica Agendada</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table>
                   <tr>
                      <th>Médico:</th><td><input type="text" id="modalDoctorNameAg" name="modalDoctorNameAg" disabled></td>
                    </tr>
                    <tr>
                      <th>Especialidad:</th><td><input type="text" id="modalSpecialityNameAg" name="modalSpecialityNameAg" value="{{ session('specialityName') }}" disabled></td>
                    </tr>
                    <tr>
                      <th>Paciente:</th><td><input type="text" id="modalPatientNameAg" name="modalPatientNameAg" value="{{ session('patientName') }}" disabled></td>
                    </tr>
                    <tr>
                        <th>Fecha:</th><td><input type="text" id="fechaAg" name="fechaAg" disabled></td>
                    </tr>
                    <tr>    
                        <th>Hora</th><td><input type="text" id="start_timeAg" name="start_timeAg" disabled></td>
                    </tr>
                                 
                </table>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
              <input type="hidden" id="patientName" name="patientName" value="{{ session('patientName') }}">
              <input type="hidden" id="doctor_id" name="doctor_id" value="{{ session('doctor_id') }}">
              <input type="hidden" id="doctorName" name="doctorName" value="{{ session('doctorName') }}">
              <input type="hidden" id="spetiality" name="spetiality" value="{{ session('spetiality') }}">
              <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">

              <input type="hidden" id="end_time" name="end_time">              
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
        </form>
      </div>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>

      //function dataCalendar( schedules, json_schedules, arr_schedules_to_json) {

      function dataCalendar() {
            let salida;
            let citas=[];
            let appoints=[];

            let patient_id =  $( "#patient_id" ).val();
            let patientName =  $( "#patientName" ).val();
            let doctor_id =  $( "#doctor_id" ).val();
            let doctorName =  $( "#doctorName" ).val();
            
            let specialityName =  $( "#specialityName").val();
            //document.getElementById('sesion_id').value

            console.log("Doctor_Id:" + doctor_id);
            console.log("Doctor:" + doctorName);
            console.log("Paciente:" + patientName);
            console.log("Especialidad:" + specialityName);

            $( "#modalDoctorName").val(doctorName);
            $( "#modalPatientName").val( patientName );
            $( "#modalSpecialityName").val( specialityName );


            
            // GENERA TABLA FECHAPOSDIA
            generaTablaFechaPosDia();


            let diasSeleccionados = [1, 3];
            let now = new Date();
            let year =  now.getYear() + 1900;
            let month = now.getMonth(); // Abril (0-indexado, 0 = Enero,

            //buscahorasdiponibles();
        
            generaDiasMesEnCurso = generarDiasMes(year, month);
                                          
            //let fechasConHoras = generarRangosDiasMes(year, month, schedules);

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
                    

                      events: [
                                <?php
                                use Illuminate\Support\Facades\DB;                                
                                $sql = " select fecha.fecha, fecha.day_of_week, sch.start_time, sch.end_time, app.date, 'Disponible' as estado, '#669999' as color, ";
                                $sql = $sql ." concat(fecha.fecha,'T', sch.start_time) as fechastart, ";
                                $sql = $sql ." concat(fecha.fecha,'T', sch.end_time) as fechaend ";
                                $sql = $sql ." from fechaposdias fecha ";
                                $sql = $sql ." left join schedules sch on ( fecha.day_of_week = sch.day_of_week ) ";
                                $sql = $sql ." left join appointments app on ( fecha.fecha =  app.date and sch.start_time = app.start_time) ";
                                $sql = $sql ." where sch.doctor_id = 3 ";
                                $sql = $sql ." and  app.date is null ";
                                $sql = $sql ." union ";
                                $sql = $sql ." select fecha.fecha, fecha.day_of_week, sch.start_time, sch.end_time, app.date, 'Agendado' as estado, '#0000ff' as color, ";
                                $sql = $sql ." concat(fecha.fecha,'T', sch.start_time) as fechastart, ";
                                $sql = $sql ." concat(fecha.fecha,'T', sch.end_time) as fechaend ";
                                $sql = $sql ." from fechaposdias fecha ";
                                $sql = $sql ." left join schedules sch on ( fecha.day_of_week = sch.day_of_week ) ";
                                $sql = $sql ." left join appointments app on ( fecha.fecha = app.date  and sch.start_time = app.start_time) ";
                                $sql = $sql ." where sch.doctor_id = 3";
                                $sql = $sql ." and   sch.doctor_id = app.doctor_id ";
                                $sql = $sql ." and  app.id is not null";
                                $sql = $sql ." and  sch.id is not null ";

                                $registros = DB::select( $sql );             

                                foreach( $registros as $fila) {
                                ?>
                                        {
                                            'start': '<?php echo $fila->fechastart ?>',
                                            'end': '<?php echo $fila->fechaend ?>',
                                            'title': '<?php echo $fila->estado ?>',
                                            'color': '<?php echo $fila->color ?>'
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
                        /*
                            console.log("dateClicked on:" + info.dateStr  ); // e.g., "2023-10-27"
                            let now = new Date();
          
                            if(  info.date > now  ){ // Evitar que se abra el modal para fechas pasadas
                                 $("#modal").modal("show"); 
                              } else {     
                                alert("La Fecha seleccionada es pasada");                           //alert("No puedes seleccionar una fecha pasada");
                            }

                            $("#fecha").val(info.dateStr.substring(0, 10));  // 2026-03-30T14:00:00

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
                            */
                            
                        },

                        
                        eventClick:function(info){

                              console.log("*****evento Click");
                              console.log('Title: ' + info.event.title);

                              console.log("Fecha:" + info.event.start.toISOString().slice(0, 10)); // 2026-03-30
                              console.log('Start: ' + info.event.start);
                              
                              console.log("Hora:" + info.event.start.toString().split(' ')[4]  ); // 14:00:00
                              console.log("Medico:" + doctorName); // 14:00:00
                              console.log("Paciente:" + doctorName); // 14:00:00


                              if( info.event.title == 'Agendado') {
                                 $("#fechaAg").val( info.event.start.toISOString().slice(0, 10));
                                 $("#start_timeAg").val( info.event.start.toString().split(' ')[4] );
                                 $("#modalDoctorNameAg").val( doctorName);
                                 $("#modalPacienteNameAg").val( pacienteName);
                                 $("#modalSpecialityNameAg").val( specialityName);

                                 $("#fechaModal").val( info.event.start.toISOString().slice(0, 10));
                                 $("#startTimeModal").val( info.event.start.toString().split(' ')[4]  );

                                   $("#modalAgendado").modal("show");
                              } else {
                                    if( info.event.title == 'Disponible') {
                                        $("#modalDoctorName").val( doctorName );
                                        $("#modalSpecialityName").val( specialityName );
                                        $("#modalPatientName").val( patientName );

                                        $("#modalFecha").val( info.event.start.toISOString().slice(0, 10));
                                        $("#modalStartTime").val( info.event.start.toString().split(' ')[4]  );

                                        $("#fecha").val( info.event.start.toISOString().slice(0, 10));                                        
                                        $("#startTime").val( info.event.start.toString().split(' ')[4]  );
                                        
                                        $("#modal").modal("show"); 
                                    }
                              }
                              
                              
                              {
                                    let now = new Date();
          
                                    if(  info.event.start > now  ){ // Evitar que se abra el modal para fechas pasadas
                                        $("#fecha").val( info.event.start.toISOString().slice(0, 10));
                                        $("#start_time").val( info.event.start.toString().split(' ')[4] );
                                        $("#modalDoctorName").val( doctorName);
                                        $("#modalPacienteName").val( pacienteName);
                                        $("#modalSpecialityName").val( specialityName);

                                        //$("#end_time").val(fecha_fin.toTimeString({ hour12: false }).substring(0, 8)  ); // 14:30:00
                                        $("#modal").modal("show"); 
                                        console.log("Abrir modal");
                                    } else {     
                                        alert("La Fecha seleccionada es pasada");                           //alert("No puedes seleccionar una fecha pasada");
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

      function obtenerFechasPorDias(year, month, daysOfWeek, arr_schedules) {
              let dates = [];
              let date = new Date(year, month, 1); // Primer día del mes

              console.log("arr_schedules:" + arr_schedules.length);
              console.log("arr_schedules_NroDia:" + arr_schedules[0].day_of_week);
              console.log("arr_schedules_HoraInicio:" + arr_schedules[0].start_time);
              console.log("arr_schedules_HoraFin:" + arr_schedules[0].end_time);

              schedules.forEach( function(schedule) {
                  //console.log("**** Schedule:" + schedule.day_of_week + ' - ' + schedule.start_time + ' - ' + schedule.end_time);
              });


              
              // Mientras sigamos en el mismo mes
              while (date.getMonth() === month) {
                  // Verificar si el día de la semana actual está en el array
                  if (daysOfWeek.includes(date.getDay())) {
                      // Formatear a YYYY-MM-DD
                      let isoDate = date.toISOString().slice(0, 10);
                      dates.push(isoDate);
                  }
                  // Pasar al siguiente día
                  date.setDate(date.getDate() + 1);
              }
              return dates;
          }

          function fechaAgregaHoras( fechasDelMes) {
              let horaInicio = "08:00:00";
              let horaFin = "17:00:00";
              let minutosAgregar = 15;

              fechaDelMesMasHora = [];

              console.log("***** CONSIDERAS LOS DIAS DEL SCHEDULE MAS LAS HORAS DE ATENCION DEL DOCTOR PARA CREAR LOS EVENTOS DISPONIBLES EN EL CALENDARIO *****");
              for (let iDia = 0; iDia < fechasDelMes.length; iDia++) {
                  fechaDelMesMasHora = fechasDelMes[iDia] + "T" + horaInicio; // "2026-04-01T08:00:00"
                  console.log( "Fecha y Hora Inicio: " + fechaDelMesMasHora);
                  nuevaHora = new Date(fechaDelMesMasHora);
                  for( minuto = 0; minuto < 3; minuto++ ) {                        
                        nuevaHora.setMinutes(nuevaHora.getMinutes() + minutosAgregar);
                        console.log("Fecha y Hora Inicio: " + nuevaHora.toString());                           
                  }
                  //; hora = sumarMinutos(hora, intervaloMinutos) ) {
                   //   let fecha_hora_inicio = $fechasDelMes[i] + "T" + hora; // "2026-04-01T08:00:00"
                   //   console.log("Fecha y Hora Inicio: " + fecha_hora_inicio);
              }         
              return fechaDelMesMasHora;                        
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

          function generarRangosDiasMes(year, month, arr_schedules){
              let fechasConHoras = [];
              let date = new Date(year, month, 1); // Primer día del mes
              console.log( "Generar rangos de dias del mes para el calendario: " + date.toISOString().slice(0, 10) );
              // Mientras sigamos en el mismo mes
              while (date.getMonth() === month) {
                  // Formatear a YYYY-MM-DD
                  let isoDate = date.toISOString().slice(0, 10);
                  let diaSemana = date.getDay();
                  //console.log( ">>>>>>> arr_schedules" + arr_schedules[0]['day_of_wek']);

                  arr_schedules.forEach( function(schedule) {
                      if( schedule.day_of_week == diaSemana ) {
                          //const [fecha, hora] = schedule.split('T');
                          //console.log("**** Schedule:" + fecha, hora );
                          let fecha_hora_inicio = schedule.start_time; 
                          let fecha_hora_fin = schedule.end_time; 
                      }
                  });
                  // Pasar al siguiente día
                  date.setDate(date.getDate() + 1); 
              }
              return fechasConHoras;
          }

          function generaFechaPosicionHoraInicial(generaDiasMesEnCurso, schedules, arr_schedules_to_json, citas) {

                FechaPosicionHoraInicial = [];

                arr_schedules_to_json.forEach( function(x) {
                      console.log( "SCHS_JSON:" + x.doctor_id + ' ' + x.day_of_week + ' ' + x.start_time + ' ' + x.end_time );
                });



                arr_sch = [];
                schedules.forEach( function(sch) {
                    let doctor_id = sch.doctor_id;
                    let num_dia = sch.day_of_week;
                    let fecha_hora_inicio = sch.start_time; 
                    let fecha_hora_fin = sch.end_time; 

                   // console.log( "SHCS: " + doctor_id + ' ' + num_dia + ' ' + fecha_hora_inicio.split('T')[1].substring(0,8) + ' ' + fecha_hora_fin.split('T')[1].substring(0,8));
                    
                    arr_sch.push( {
                      'posDia' : num_dia,
                      'horaInicio' : fecha_hora_inicio.split('T')[1].substring(0,8) ,
                      'horaFin' : fecha_hora_fin.split('T')[1].substring(0,8) 
                    });
                            
                });

                arr_sch.forEach( function(x) {
                    //console.log("arr_sch::" + x.posDia + ' ' + x.horaInicio );
                });  

                for( i=0; i< arr_sch.length; i++) {
                  //console.log("FOR_ARR_ASCH::" + arr_sch[i].posDia + ' ' + arr_sch[i].horaInicio);
                }

                for( i=0; i< generaDiasMesEnCurso.length; i++) {
                  //console.log("MES_POS_FECHA::" + generaDiasMesEnCurso[i].diaSemana + ' ' + generaDiasMesEnCurso[i].fecha );
                    for( j=0; j< arr_schedules_to_json.length; j++) {
                        //console.log( "COMPARACION::" + generaDiasMesEnCurso[i].diaSemana + ' '  + arr_schedules_to_json[j].day_of_week);
                      if( generaDiasMesEnCurso[i].diaSemana == arr_schedules_to_json[j].day_of_week) {
                        console.log(">>>>> MACH::" + generaDiasMesEnCurso[i].fecha + ' ' + generaDiasMesEnCurso[i].diaSemana + ' ' + arr_schedules_to_json[j].day_of_week + ' ' + arr_schedules_to_json[j].start_time);
                        FechaPosicionHoraInicial.push (
                            {
                                'fecha'  :  generaDiasMesEnCurso[i].fecha,
                                'doctor_id' :  arr_schedules_to_json[j].doctor_id,
                                'diaSemana' : generaDiasMesEnCurso[i].diaSemana,
                                'horaInicio' : arr_schedules_to_json[j].start_time ,
                                'horaFin' : arr_schedules_to_json[j].end_time 
                            }
                        )
                      }
                      
                      
                    } 
                }
                return FechaPosicionHoraInicial;
          }


          /*
          async function cargarApoointmentsByDoctorId( doctor_id ) {
                try {
                    const response = await fetch('https://localhost:8080/api/appointmentsByDoctorId?doctor_id='+ doctor_id,
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        });
                    const data = await response.json();
                    console.log(data);
                } catch (error) {
                    console.error('Error:', error);
                }
                return data;
            }
                */


      

        async function ABC(doctor_id) {
            const url = 'api/appointmentsByDoctorId?doctor_id=3';
            try {
                const response = await fetch( url );
                const data = await response.json();
                return data;
            } catch (error) {
                console.error("Network or Parsing Error:", error);
            }
        }

        function ABCD( doctor_id)  {

                let salida =  fetch( 'http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3' )
                    .then(response => {
                            if (!response.ok) {
                            throw new Error('Network response was not ok');
                            }

                            return response.json(); // Parses JSON body
                    })
                    .catch(error => console.error('Fetch error:', error));
                return salida;

        }

       


        function ABCDE( doctor_id)  {
            let salida=[];

                return fetch( 'http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3' )
                .then(response => {
                    // Verificar si la respuesta es correcta
                    if (!response.ok) {
                    throw new Error('Error de red');
                    }
                    return response.json(); // Convierte la respuesta a JSON
                })
                
                .then(data => {
                    for(let elem of data ) {
                        let info = {
                            'id' :  elem['id'],
                            'doctor_id': elem['doctor_id'] ,
                            'date' : elem['date'],
                            'start_time' :  elem['start_time'],
                            'end_time' : elem['end_time']
                        };
             
                        console.log( elem['id'] + ' ' + elem['doctor_id'] + ' ' + elem['date'] + ' ' +  elem['start_time']  + ' ' +  elem['end_time']);
                        salida.push(info );
                    }

                    for (let sal of salida) {
                            console.log("SALIDA_ID:::" + sal.id);
                        }
                    //return data;
                    //salida.push( data );
                    //console.log(data); // Aquí ya tienes los datos
                    //console.log( "SALIDA:" + salida);
                    //var myJsonString = JSON.stringify(salida);
                    //console.log( myJsonString);
                    //return salida;
                })
                .catch(error => {
                    console.error('*************  Error:', error);
                });
            
        }


        function csanta( doctor_id) {
            let salida = [];
            axios.get('http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3')
                .then(function (response) {
                    console.log(response.data); // Datos del servidor
                    salida = response.data;
                    console.log( salida );
                    return salida;
                })
                .catch(function (error) {
                    console.log(error);
                });
            
         }

          function  agregaInfoCitas(FechaPosicionHoraInicial, citas) {
            //console.log("agregaInfoCitas");
            //console.log( FechaPosicionHoraInicial );
            /*
               console.log(" Recorre Schedules - Citas");
               for(let i=0; i<FechaPosicionHoraInicial.length;i++) {
                    console.log("SCHEDULES ---->"+ citas.length );
                    for(let j=0; j<citas.length;j++) {
                        console.log("CITAS ---->");
                        console.log( FechaPosicionHoraInicial[i]['fecha'] + ' <=> ' + citas[j]['date']);
                        if( FechaPosicionHoraInicial[i]['fecha'] == citas[j]['date'] && FechaPosicionHoraInicial[i]['doctor_id'] ==  citas[j]['doctor_id']  && FechaPosicionHoraInicial[i]['horaInicio'] ==  citas[j]['horaInicio']) {
                            console.log("SCH_CITAS_MATCH");
                        }                                        
                    }                      
               }
                    */

               //console.log(" Recorre Citas");
               //console.log( citas );
               //for(let i=0; i<citas.length;i++) {
               //    console.log(citas[i]['id'] + ' ' + citas[i]['doctor_id'] + ' ' + citas[i]['date']);                   
//
  //             }

          }


          async function obtenerArreglo() {
                    try {
                        // La respuesta esperada es un array: [{}, {}, {}]
                        const response = await axios.get('http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3');
                        
                        // response.data contiene el arreglo JSON
                        const miArreglo = response.data;
                        console.log(miArreglo);
                        return miArreglo;
                    } catch (error) {
                        console.error('Error al obtener datos:', error);
                    }
            }


            function Ahora(){
                     axios.get('http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3')
                        .then(function (response) {   
                            console.log( response.data);
                            //return rsponse.data;                                                 
                        });
            }

            function AhoraSi() {
                 fetch( 'http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3' )
                .then(response => {
                    // Verificar si la respuesta es correcta
                    if (!response.ok) {
                    throw new Error('Error de red');
                    }
                    console.log( response.json );
                    //return response.json(); // Convierte la respuesta a JSON
                })
            }

            function ahoraSiQueSi() {
                fetch( 'http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3' )
                .then(response => {
                    // Verificar si la respuesta es correcta
                    if (!response.ok) {
                    throw new Error('Error de red');
                    }
                    console.log( response.json());
                    //return response.json(); // Convierte la respuesta a JSON
                })
            }
       

            async function obtenerDatos() {
                try {
                    // 1. Esperar la respuesta de la API
                    const respuesta = await fetch('http://localhost:8080/api/appointmentsByDoctorId?doctor_id=3');
                    
                    // 2. Verificar si la respuesta es correcta
                    if (!respuesta.ok) {
                        throw new Error('Error en la red');
                    }
                    
                    // 3. Convertir la respuesta a JSON
                    const datos = await respuesta.json();
                    
                    // 4. Visualizar los datos
                    console.log(datos);
                    const miDiv = document.getElementById("citas");
                    miDiv.innerHTML = JSON.stringify(datos);
                    
                    //salida = JSON.stringify(datos);
                    // O mostrarlos en el DOM: document.body.innerHTML = JSON.stringify(datos);
                    
                } catch (error) {
                    console.error('Error al obtener datos:', error);
                }
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

            function buscahorasdiponibles(){
                axios.get('http://localhost:8080/api/buscahorasdiponibles')
                        .then(  function(response) {   
                            //console.log( response.data);
                            //return rsponse.data;                                                 
                        })
                        .catch( function( err) {
                              console.log('Error', err.message);
                        });
            }

    </script>     

@endsection