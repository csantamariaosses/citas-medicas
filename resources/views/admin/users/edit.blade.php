@extends('layouts.app')

@section('menu')
  @include('menuadmin')
@endsection 

@section('content')


    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h3>Editar Usuario::</h3>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <form action="{{ route('users.update', $user->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ $user->name }}">
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $user->email }}">
              </div>
              <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>

              <div class="mb-3">
                  <label for="role" class="form-label">Role</label>

                    <select class="form-select" aria-label="Default select example" name="role">
                        <option value="0" >Seleccione...</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
              </div>
           
              <button class="btn btn-success" type="submit">Actualizar</button>
              <button class="btn btn-secondary" type="button" onclick="window.history.back();">Cancelar</button>
            </form> 
        </div>
    </div>

@endsection