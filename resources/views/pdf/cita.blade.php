<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
      /** Define the margins of your page **/
      @page {
      margin: 100px 25px;
      }

      header {
      position: fixed;
      top: -60px;
      left: 0px;
      right: 0px;
      height: 130px;

      /** Extra personal styles **/
      background-color: #f1f5f7;
      color: black;
      text-align: center;
      line-height: 35px;
      }

      footer {
      position: fixed;
      bottom: -60px;
      left: 0px;
      right: 0px;
      height: 100px;

      /** Extra personal styles **/
      background-color: #f1f5f7;
      color: black;
      text-align: center;
      line-height: 35px;
      }

      .subrayado {
          text-decoration: underline;
      }
</style>

</head>
<body>
     <div class="container">
         <header>
            <p align='center'><img src='images/logo_centro_medico.png' width='80'></p>
            <br>
            <p align='center'>CENTRO INTEGRAL DE SALUD</p>
        </header>
        
          <br><br><br><br><br><br><br>
          <hr>
          <P>Médico: {{ $registro->doctorName }}</p>
          <P>Especialidad: {{ $registro->specialityName }}</p>
          <hr>
          <P>Nombre Paciente: {{ $registro->patientName }}</p>
          <P>Email Paciente: {{ $registro->patientEmail }}</p>
          
          <p>Fecha: {{ $registro->date}}</p>
          <br><br>
           <span class="subrayado">Diagnostico: </span><br>
           {{ $registro->diagnostic}}
          
          <br><br>          
          <span class="subrayado">Prescripcion:</span><br>
          {{ $registro->prescriptions}}
          
          <br><br>
          <span class="subrayado">Tratamiento:</span><br>
          {{ $registro->treatment}}
          
          


          <footer>
          Firma y Timbre del médico
          <br>
          </footer>

    </div>
      
</body>
</html>