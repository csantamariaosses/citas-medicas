@extends('layouts.app')
@section('menu')
  @include('menu')
@endsection
@section('content')

  <div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-3">  
              <div class="card">
                   <div class="card-header">
                        <p class="text-center">LOGIN</p>
                   </div>
                   <div class="card-body">
                        <div class="mb-3">
                          <label for="email" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="email" placeholder="name@example.com">
                       </div>
                       <div class="mb-3">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" class="form-control" id="password" placeholder="password">
                       </div>
                       <div class="d-grid gap-2">
                                <button class="btn btn-primary" >Ingresar</button>
                      </div>

                   </div>
                   <div class="card-footer">
                        <h3>Footer</h3>
                   </div>                   
              </div>
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
