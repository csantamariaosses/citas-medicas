@extends('layouts.app')
@section('menu')
  @include('menu')
@endsection
@section('content')

  <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h1>HOME</h1>
            <p>Bienvenido a la página de inicio.</p>
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
