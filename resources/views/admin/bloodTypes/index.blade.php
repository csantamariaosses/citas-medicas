@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')

   <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
      <h3>Tipos de Sangre</h3>
        <a href="{{ route('bloodTypes.create') }}">Crear Tipo de Sangre</a>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @if( isset($bloodTypes) && count($bloodTypes) > 0 )
              @foreach($bloodTypes as $row)
              <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>

                <td>
                  <a href="{{ route('bloodTypes.show', $row->id) }}">Ver</a>
                  <a href="{{ route('bloodTypes.edit', $row->id) }}">Editar</a>

                  <form action="{{ route('bloodTypes.destroy', $row->id) }}" 
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
                <td colspan="3">No hay tipos de sangre registrados.</td>
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
