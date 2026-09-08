@extends('layouts.datatables')

@section('menu')
  @include('menuadmin')  
@endsection

@section('content')
<style>
  .red_font {
    color: red;
  }
</style>

    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Doctores::</h3>
          <!--https://datatables-net.translate.goog/extensions/buttons/examples/initialisation/export.html?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=tc -->
        </div>
    </div>

     <div>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Crear Doctor</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPaciente">
                                Crear Doctor Modal
                            </button>
     </div>
      <hr>
      <div class="row">
        <div class="col-12">
            <table id="example" class="display nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <td>User_id</td>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Telefono</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $doctores as $doctor )
                    <tr>
                        <td>{{ $doctor->id }}</td>
                        <td>{{ $doctor->user->id }}</td>
                        <td>{{ $doctor->user->name }}</td> 
                        <td>{{ $doctor->speciality->name }}</td>          
                        <td>{{ $doctor->user->email }}</td>
                        <td>{{ $doctor->user->address }}</td>
                        <td>{{ $doctor->user->phone }}</td>
                       
                        <td>{{ $doctor->active ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$doctor->id}}">
                                Ver Info
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modificarModal-{{$doctor->id}}">
                                Modificar
                            </button>
                            <a href="{{ route('doctores.schedules', $doctor->id) }}" class="btn btn-info" target="_blank">Ver Horarios</a>

                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                <tfoot>
                  <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Especialidad</th>
                      <th>Email</th>
                      <th>Dirección</th>
                      <th>Telefono</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                  </tr>
                </tfoot>
            </table>
        </div>
      </div>
    </div>
  


<!-- Modal -->
@foreach ($doctores as $doctor)
<div class="modal fade" id="exampleModal-{{$doctor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ficha Paciente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
        <p><span class="fw-bold">Nombre:</span> {{ $doctor->user->name }}</p>
    

        <p><span class="fw-bold">Email:</span> {{ $doctor->user->email }}</p>
        <p><span class="fw-bold">Dirección:</span> {{ $doctor->user->address }}</p>
        <p><span class="fw-bold">Teléfono:</span> {{ $doctor->user->phone }}</p>
    
        <hr>
  
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
 @endforeach


 <!-- Modal Modificar Paciente -->

@foreach ($doctores as $doctor)
<div class="modal fade" id="modificarModal-{{$doctor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ficha Doctor Modifica</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('doctores.update', $doctor->id) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $doctor->id }}"> 
          <p><span class="fw-bold">Nombre:<input type="text" name="name" class="form-control" value="{{ $doctor->user->name }}"/></p>
       
          <p><span class="fw-bold">Email:<input type="email" name="email" class="form-control" value="{{ $doctor->user->email }}"/></p>
          <p><span class="fw-bold">Dirección:<input type="text" name="address" class="form-control" value="{{ $doctor->user->address }}"/></p>
          <p><span class="fw-bold">Teléfono:<input type="text" name="phone" class="form-control" value="{{ $doctor->user->phone }}"/></p>
          <p><span class="fw-bold">Especialidad:
    
            <select name="speciality" class="form-select">
               @foreach($specialities as $speciality)
                <option value="{{ $speciality->id }}" {{ $doctor->speciality_id == $speciality->id ? 'selected' : '' }}>{{ $speciality->name }}</option>
               @endforeach
              
            </select> 
          <p>
            <p><span class="fw-bold">Número de licencia médica:<input type="text" name="medical_license_number" class="form-control" value="{{ $doctor->medical_license_number }}"/></p>
          <p>
          <p><span class="fw-bold">Estado:
            <select name="active" class="form-select">
              <option value="1" {{ $doctor->active ? 'selected' : '' }}>Activo</option>
              <option value="0" {{ !$doctor->active ? 'selected' : '' }}>Inactivo</option>
            </select>
          </p>
         
          <hr> 
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>  
        </form> 
      </div>


      <div class="modal-footer">
        <hr>
      </div>
    </div>
  </div>
</div>
 @endforeach


 <!-- Modal Crear Doctor -->
 <div class="modal fade" id="modalCrearPaciente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Doctor::</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
       <form action="{{ route('doctores.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nombre::</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="nombre" required>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email::</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                </div>

                <div class="mb-3">
                  <label for="address" class="form-label">Dirección:</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" required>
                </div>

                <div class="mb-3">
                  <label for="phone" class="form-label">Teléfono:</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" required>
                </div>

                <div class="mb-3">
                  <label for="speciality" class="form-label">Especialidad:</label>
                  <select name="speciality" class="form-select" required>
                    <option value="">Seleccione...</option>
                    @foreach($specialities as $speciality)
                      <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                    @endforeach
                  </select>
                </div>  
                                
                <div class="mb-3">
                  <label for="email" class="form-label">Rol</label>
                  <select class="form-select" aria-label="Default select example" name="role" required>
                      <option value="0" selected>Seleccione...</option>
                    @foreach($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label for="medical_license_number" class="form-label">Número de licencia médica:</label>
                  <input type="text" class="form-control" id="medical_license_number" name="medical_license_number" placeholder="Número de licencia médica" required>
                </div>

                               
                <div class="mb-3">
                  <label for="observations" class="form-label">Observaciones:</label>
                  <textarea rows="3" name="observations" class="form-control" id="observations" placeholder="Observaciones"></textarea>

                </div>                                       
                
                <div class="mb-3">
                  <label for="emergency_contact_name" class="form-label">Nombre contacto:</label>
                  <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" placeholder="Nombre Contacto Emergencias" required>
                </div>    

              <div class="d-grid gap-2 d-md-block">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button class="btn btn-primary" type="submit">Crear</button>
                
              </div>
          </form>
        
      </div>


      <div class="modal-footer">
         <hr>
      </div>
    </div>
  </div>
</div>
@endsection


