<div>
    <div x-data="dataCalendar()">
        <div x-ref="calendar"></div> 
    </div>

    <!--- Modales -->


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function dataCalendar() {
                console.log("entra a dataCalendar");
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
                console.log("Doctor Name:" + doctorName);
                console.log("Paciente:" + patientName);
                console.log("Especialidad:" + specialityName);

                $( "#modalDoctorName").val(doctorName);
                $( "#modalPatientName").val( patientName );
                $( "#modalSpecialityName").val( specialityName );


                
                // GENERA TABLA FECHAPOSDIA
                console.log("Genera Tabla FechaPosDia");
                generaTablaFechaPosDia();


                //let diasSeleccionados = [1, 3];
                let now = new Date();
                let year =  now.getYear() + 1900;
                let month = now.getMonth(); // Abril (0-indexado, 0 = Enero,

            
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

                                /*if( info.event.start < now ) {
                                    alert("La Fecha seleccionada es pasada");  
                                } else {
                                */
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
                                /*}      */                                                                                   
                            },
                            hiddenDays: [ 0 ]
                    });
                    
                    calendar.render();
                       console.log("Calendario Doctor cargado");
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


    <!--- Modales -->
     <!-- Modal -->
      <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="{{ route('agendapatient.confirmar') }}" method="POST">
          @csrf 
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header"  style="background-color: #669999; color: #ffffff;"      >
              <h5 class="modal-title" id="staticBackdropLabel">Confirmación de Hora---</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"  style="background-color: #fff;">
                <table>
                    <tr>
                      <th>Estado Hora:</th><td><span id="modalStatus" name="modalStatus"></td>
                    </tr>
                   <tr>
                      <th>Médico:</th><td><input type="text" id="modalDoctorName" name="modalDoctorName" disabled></td>
                    </tr>
                    <tr>
                      <th>Especialidad:</th><td><input type="text" id="modalSpecialityName" name="modalSpecialityName"  disabled></td>
                    </tr>
                    <tr>
                        @if( session('patientName') != 'NN')
                         <th>Paciente:</th><td><input type="text" id="modalPatientName" name="modalPatientName" disabled></td>
                        @else
                         <th>Paciente:</th><td>
                           <select name="selectPatient_id">
                             <option value="0">Seleccione un paciente</option>
                              @foreach($patients as $patient)
                                  <option value="{{ $patient->id }}">{{ $patient->id }}-{{ $patient->user->name }}</option>
                             @endforeach
                           </select>
                        </td>
                       @endif

                    </tr>
                    <tr>
                        <th>Fecha:</th><td><input type="text" id="modalFecha" name="modalFecha" disabled></td>
                    </tr>
                    <tr>    
                        <th>Hora</th><td><input type="text" id="modalStartTime" name="modalStartTime" disabled></td>
                    </tr>
                                 
                </table>
            </div>
            <div class="modal-footer" style="background-color: #fff;">
              <input type="hidden" id="status" name="status" value="{{ session('status') }}">
              <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">  
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
              <button type="submit" class="btn btn-primary" disabled>Confirmar</button>
            </div> <!-- modal-footer -->
          </div>   <!-- modal-content -->
        </div>     <!-- modal-dialog -->
        </form>
      </div>       <!-- modal fecha disponible-->


      <!-- Modal  Agendado-->
      <div class="modal fade" id="modalAgendado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="{{ route('agendapatient.cancelar') }}" method="POST">
          @csrf 
         
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header"  style="background-color: #a58d13; color: #ffffff;" > 
              <h5 class="modal-title" id="staticBackdropLabel">Informacion de la Hora Medica Agendada</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #fff;">
                <table>
                    <tr>
                      <th>Cita Id::</th><td><input type="text" id="modalCitaIdAg" name="modalCitaIdAg" disabled></td>
                    </tr>
                    <tr>
                      <th>Médico Id:</th><td><input type="text" id="modalDoctorIdAg" name="modalDoctorIdAg" disabled></td>
                    </tr>
                   <tr>
                      <th>Médico:</th><td><input type="text" id="modalDoctorNameAg" name="modalDoctorNameAg" disabled></td>
                    </tr>
                    <tr>
                      <th>Especialidad:</th><td><input type="text" id="modalSpecialityNameAg" name="modalSpecialityNameAg" value="{{ session('specialityName') }}" disabled></td>
                    </tr>
                    <tr>
                      <th>Id Paciente:</th><td><input type="text" id="modalPatientIdAg" name="modalPatientIdAg"  disabled></td>
                    </tr>
                    <tr>
                    <tr>
                      <th>Paciente:</th><td><input type="text" id="modalPatientNameAg" name="modalPatientNameAg"  disabled></td>
                    </tr>
                    <tr>
                        <th>Fecha:</th><td><input type="text" id="fechaAg" name="fechaAg" disabled></td>
                    </tr>
                    <tr>    
                        <th>Hora</th><td><input type="text" id="start_timeAg" name="start_timeAg" disabled></td>
                    </tr>
                                 
                </table>
            </div>
            <div class="modal-footer" style="background-color: #fff;">
                <input type="hidden" id="modalCitaIdAgHidden" name="modalCitaIdAgHidden">
                <input type="hidden" id="modalDoctorIdAgHidden" name="modalDoctorIdAgHidden">
                <input type="hidden" id="modalPatientIdAgHidden" name="modalPatientIdAgHidden">
                <input type="hidden" id="modalFechaStartAgHidden" name="modalFechaStartAgHidden">
                <input type="hidden" id="modalFechaHoraStartAgHidden" name="modalFechaHoraStartAgHidden">
      
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal" disabled>Cancelar Cita</button>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmCancelarCitaModal" data-bs-dismiss="modal" disabled>
                CANCELAR CITA
              </button>
            </div>
          </div>
        </div>
        </form>
      </div> <!-- modal agendado -->


</div>
