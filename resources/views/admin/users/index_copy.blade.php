@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')

   <div class="container">
    <div class="row">
        <div class="col-9 offset-1">  
      <h3>Usuarios</h3>
        <a href="{{ route('users.create') }}">Crear Usuario</a>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Roles</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->getRoleNames() }}</td>  

              <td>
                <a href="{{ route('users.show', $user->id) }}">Ver</a>
                <a href="{{ route('users.edit', $user->id) }}">Editar</a>
                <form action="{{ route('users.destroy', $user->id) }}" 
                  method="POST" 
                  style="display:inline;"
                  class="delete-form">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="id" value="{{ $user->id }}">
                  <button type="submit" class="btn btn-danger">Eliminar::</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div>
    </div>

      <!-- Muestra mensaje de alerta -->
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
@endsection
