@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')

   <div class="container">
   
   </div>
    <div class="row">
        <div class="col-md-8 offset-md-2">  
      <h3>Usuarios</h3>
        <a href="{{ route('users.create') }}">Crear Usuario</a>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($usuarios as $usuario )
            <tr>
              <td>{{ $usuario->id }}</td>
              <td>{{ $usuario->name }}</td>
              <td>{{ $usuario->email }}</td>
              <td>
                <a href="{{ route('users.show', $usuario->id) }}">Ver</a>
                <a href="{{ route('users.edit', $usuario->id) }}">Editar</a>

                <form action="{{ route('users.destroy', $usuario->id) }}" 
                  method="POST" 
                  style="display:inline;"
                  class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div>
    </div>
    <br><hr>

@endsection
