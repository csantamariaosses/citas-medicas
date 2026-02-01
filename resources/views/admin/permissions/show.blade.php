  @extends('layouts.app')

@section('menu')
  @include('menu')
@endsection 

@section('content')


    <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h3>Permission</h3>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <form action="" method="POST">
              <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="name" placeholder="Nombre" value="{{ $permission->name }}" disabled>
              </div>

              <button class="btn btn-secondary" type="button" onclick="window.history.back();">Ok</button>
            </form> 
        </div>
    </div>
  
    @endsection