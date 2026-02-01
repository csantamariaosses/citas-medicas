@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')

   <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
      <h3>Roles</h3>
        <a href="{{ route('roles.create') }}">Crear Role</a>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
            <tr>
              <td>{{ $role->id }}</td>
              <td>{{ $role->name }}</td>

              <td>
                <a href="{{ route('roles.show', $role->id) }}">Ver</a>
                <a href="{{ route('roles.edit', $role->id) }}">Editar</a>

                <form action="{{ route('roles.destroy', $role->id) }}" 
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
