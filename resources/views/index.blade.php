@extends('layouts.app')
@section('menu')
  @include('menu')
@endsection
@section('content')

  <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <p>Bienvenido al sistema de Citas Médicas.</p>

            <img src="{{ asset('images/imagen_citas_medicas.jpg') }}" alt="Description of the image" class="img-fluid">
        </div>
    </div>    

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
   </div>


@endsection 
