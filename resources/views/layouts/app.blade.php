<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">    
 

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js'></script>
     

     <!-- 
     <script src="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.css"></script>
     <script src="https://cdn.datatables.net/buttons/3.2.6/css/buttons.dataTables.css"></script>
-->
     <!-- alpine.js -->
   <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> -->
    
     @include('sweetalert2::index')
     @livewireStyles
     @stack('css')
</head>
<body>
  <div class="container">
    @yield('menu')
    
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <p>Versión de Laravel:  {{ Session::get('laravel_version')}} </p>
            <p>Versión de PHP:  {{ Session::get('php_version')}} </p>
        </div>
    </div>    

    @yield('content')
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <!-- <script src="sweetalert2.all.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!--  
  <script src="https://cdn.datatables.net/2.3.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>
-->

  <!-- Muestra mensaje de alerta -->
  <!-- json transforma a json array que trae variable swal  -->
    

    
    <script>
        forms = document.querySelectorAll('.delete-form');
        forms.forEach( form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();   
                console.log(this.dataset);   
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Está seguro?',
                    text: "No podrás revertir esto!::" + this.dataset['id'],                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, elimínalo!'
                }).then((result) => {
                    if (result.isConfirmed) {   
                        form.submit();
                    }
                });
                
            });
                
        });
    </script>

    @livewireScripts

    @if(session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif 

    <script>
        Livewire.on('swal', function(data) {
            Swal.fire(data[0]);
        });
    </script>

    @stack('js')

</body>
</html>