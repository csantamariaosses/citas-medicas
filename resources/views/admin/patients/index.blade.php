@extends('layouts.app')

@section('menu')
  @include('menu')  
@endsection

@section('content')
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Pacientes</h3>
        </div>
    </div>

     <div>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Crear Paciente</a>
     <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Dirección</th>
              <th>Telefono</th>
              <th>Tipo de Sangre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($patients as $patient)
            <tr>
              <td>{{ $patient->id }}</td>
              <td>{{ $patient->user->name }}</td>
              <td>{{ $patient->user->email }}</td>  
              <td>{{ $patient->user->address }}</td>  
              <td>{{ $patient->user->phone }}</td>
              <td>{{ $patient->bloodType->name }}</td>

              <td>
                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-primary">Ver</a>
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">Editar</a>
                <form action="{{ route('patients.destroy', $patient->id) }}" 
                  method="POST" 
                  style="display:inline;"
                  class="delete-form">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="id" value="{{ $patient->id }}">
                  <button type="submit" class="btn btn-danger">Eliminar::</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>

        <hr>
        <h3>Tabla con DataTables</h3>
        <table id="example" class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Tipo de Sangre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
              @foreach($patients as $patient)
            <tr>
              <td>{{ $patient->id }}</td>
              <td>{{ $patient->user->name }}</td>
              <td>{{ $patient->user->email }}</td>  
              <td>{{ $patient->user->address }}</td>  
              <td>{{ $patient->user->phone }}</td>
              <td>{{ $patient->bloodType->name }}</td>
              <td>
                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-primary">Ver</a>
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">Editar</a>
                <form action="{{ route('patients.destroy', $patient->id) }}" 
                  method="POST" 
                  style="display:inline;"
                  class="delete-form">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="id" value="{{ $patient->id }}">
                  <button type="submit" class="btn btn-danger">Eliminar::</button>
                </form>
              </td>
            </tr>
            <tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Tipo de Sangre</th>
            </tr>
        </tfoot>
    </table>
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


