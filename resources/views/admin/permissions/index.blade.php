@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Permisos</h3>
        <a href="{{ route('permissions.create') }}">Crear Permiso</a>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $permission)
            <tr>
              <td>{{ $permission->id }}</td>
              <td>{{ $permission->name }}</td>

              <td>
                <a href="{{ route('permissions.show', $permission->id) }}">Ver</a>
                <a href="{{ route('permissions.edit', $permission->id) }}">Editar</a>
                <form action="{{ route('permissions.destroy', $permission->id) }}" 
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