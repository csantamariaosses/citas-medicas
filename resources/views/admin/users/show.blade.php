  @extends('layouts.app')

@section('menu')
  @include('menu')
@endsection 

@section('content')


    <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h3>Role</h3>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <form action="" method="POST">
              @csrf

              <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="name" placeholder="Nombre" value="{{ $user->name }}" disabled>
              </div>

               <div class="mb-3">
                    <label for="email" class="form-label">Email::</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="email" value="{{ $user->email }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Role</label>
                    <select class="form-select" aria-label="Default select example" name="role">
                        <option value="0">{{ $user->roles[0]->name }}</option>
                    </select>
                </div>

              <button class="btn btn-secondary" type="button" onclick="window.history.back();">Ok</button>
            </form> 
        </div>
    </div>
  
    @endsection