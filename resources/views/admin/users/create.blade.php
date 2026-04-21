@extends('layouts.app')
@section('menu')
  @include('menuadmin')
@endsection

@section('content')  
  
  <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">  
            <div class="card">
              <div class="card-head">
                      <h3>Crear Usuario</h3>
              </div>
              <div class="card-body">
                  <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="name" class="form-label">Nombre::</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="nombre" required>
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email::</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Role</label>
                          <select class="form-select" aria-label="Default select example" name="role">
                              <option value="0" selected>Seleccione...</option>
                            @foreach($roles as $role)
                              <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="submit">Crear</button>
                        <button class="btn btn-primary" type="button" onClick="window.history.back()">Cancelar</button>
                      </div>
                  </form>
              </div>     <!-- card-body -->       
            </div>  <!-- card -->
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->
  </div>  <!-- container --> 
  @endsection
