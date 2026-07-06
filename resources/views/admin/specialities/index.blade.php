@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')

   <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <div class="card">
                <div class="card-header">
                    <h4>Especialidades</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('specialities.create') }}" class="btn btn-primary mb-3">Crear Especialidad</a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($specialities) && count($specialities) > 0)
                                @foreach($specialities as $speciality)
                                    <tr>
                                        <td>{{ $speciality->id }}</td>
                                        <td>{{ $speciality->name }}</td>
                                        <td>
                                            <a href="{{ route('specialities.edit', $speciality->id) }}" class="btn btn-primary">Ver / Editar</a>

                                            <form action="{{ route('specialities.destroy', $speciality->id) }}" method="POST" style="display:inline;" class="delete-form">
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
            </div>
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
