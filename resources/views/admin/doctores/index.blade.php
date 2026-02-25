@extends('layouts.app')

@section('menu')
  @include('menu')  
@endsection

@section('content')
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Doctores</h3>
        </div>
    </div>

     <div>
        <a href="{{ route('doctores.create') }}" class="btn btn-primary">Crear Doctor</a>
     <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Rol</th>
              <th>Especialidad</th>
              <th>Email</th>
              <th>Dirección</th>
              <th>Telefono</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($doctores as $doctor)
            <tr>
              <td>{{ $doctor->id }}</td>
              <td>{{ $doctor->user->name }}</td>
              <td>{{ $doctor->user->getRoleNames()->first()}}</td>
              <td>{{ $doctor->speciality->name }}</td>
              <td>{{ $doctor->user->email }}</td>  
              <td>{{ $doctor->user->address }}</td>  
              <td>{{ $doctor->user->phone }}</td>
              <td>{{ $doctor->active ? 'Activo' : 'Inactivo' }}</td>
              <td>
                <a href="{{ route('doctores.show', $doctor->id) }}" class="btn btn-primary">Ver</a>
                <a href="{{ route('doctores.edit', $doctor->id) }}" class="btn btn-primary">Editar::</a>
                <form action="{{ route('doctores.destroy', $doctor->id) }}" 
                  method="POST" 
                  style="display:inline;"
                  class="delete-form">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="id" value="{{ $doctor->id }}">
                  <button type="submit" class="btn btn-danger">Eliminar::</button>
                </form>
                <a href="{{ route('doctores.schedules', $doctor->id) }}" class="btn btn-info">Ver Horarios</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>

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


