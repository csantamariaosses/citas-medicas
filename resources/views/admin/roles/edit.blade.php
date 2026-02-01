@extends('layouts.app')

@section('menu')
  @include('menu')
@endsection 

@section('content')


    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h3>Editar Role Admin</h3>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="{{ $role->name }}">
              </div>
           
              <button class="btn btn-success" type="submit">Actualizar</button>
              <button class="btn btn-secondary" type="button" onclick="window.history.back();">Cancelar</button>
            </form> 
        </div>
    </div>

@endsection