@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')

   <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
      <h3>Especialidades</h3>
        <a href="{{ route('specialities.create') }}">Crear Especialidad</a>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if( isset($specialities) && count($specialities) > 0 )
              @foreach($specialities as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>

                <td>
                  <a href="{{ route('specialities.show', $row->id) }}">Ver</a>
                  <a href="{{ route('specialities.edit', $row->id) }}">Editar</a>

                  <form action="{{ route('specialities.destroy', $row->id) }}" 
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
            @else
              <tr>
                <td colspan="3">No hay especialidades registradas.</td>
              </tr>
            @endif
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
