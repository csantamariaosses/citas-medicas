@extends('layouts.app')

@section('menu')
  @include('menu')  
@endsection

@section('content')
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Funcionarios</h3>
        </div>
    </div>

     <div>
        <a href="{{ route('funcionarios.create') }}" class="btn btn-primary">Crear Funcionario</a>
     <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Rol</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Dirección</th>
              <th>Telefono</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($funcionarios as $funcionario)
            <tr>
              <td>{{ $funcionario->id }}</td>
              <td>{{ $funcionario->user->name }}</td>
              <td>{{ $funcionario->user->email }}</td>  
              <td>{{ $funcionario->user->address }}</td>  
              <td>{{ $funcionario->user->phone }}</td>
              <td>{{ $funcionario->bloodType->name }}</td>

              <td>
                <a href="{{ route('funcionarios.show', $funcionario->id) }}" class="btn btn-primary">Ver</a>
                <a href="{{ route('funcionarios.edit', $funcionario->id) }}" class="btn btn-primary">Editar</a>
                <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" 
                  method="POST" 
                  style="display:inline;"
                  class="delete-form">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="id" value="{{ $funcionario->id }}">
                  <button type="submit" class="btn btn-danger">Eliminar::</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>

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


<script>
    new DataTable('#example', {
        /*
      dom: 'Bfrtip',
      buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print' // Añade 'pdf' aquí
      ]
            */
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            }
        }
    });
 </script>     
@endsection


