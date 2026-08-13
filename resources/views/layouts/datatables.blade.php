<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
    <!-- pagina de datatables
    https://datatables-net.translate.goog/extensions/buttons/examples/initialisation/export.html?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=tc
    -->

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- para datatables -->
    <link href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css" rel="stylesheet">

    <!-- para livewire -->
     @livewireStyles

</head>
<body>
  <div class="container">
        @yield('menu')

        <div class="row">
             <div class="col-md-6 offset-md-3">  
                <p>Versión de Laravel: {{ Session::get('laravel_version')}} </p>
                <p>Versión de PHP:  {{ Session::get('php_version')}} </p>
             </div>
        </div>   <!-- row --> 

        @yield('content')
  </div> <!-- container -->

  <!-- bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- bootstrap -->

  <!-- para datatables -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" ></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>

  <script>
      new DataTable('#example', { layout: { topStart: { buttons: ['copy', 'csv', 'excel', 'pdf', 'print'] } } });
  </script>


  <!-- Muestra mensaje de alerta -->
  <!-- json transforma a json array que trae variable swal  -->
       

  <!-- scripts livwwire -->  
  @livewireScripts


</body>
</html>