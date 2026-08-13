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
          <h3>Pacientes::</h3>
          <!--https://datatables-net.translate.goog/extensions/buttons/examples/initialisation/export.html?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=tc -->
        </div>
    </div>

     <div>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Crear Paciente</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPaciente">
                                Crear Paciente Modal
                            </button>
     </div>
      <hr>
      <div class="row">
        <div class="col-10">
            <table id="example" class="display nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Fecha Nac.</th>
                        <th>Edad</th>
                        <th>Email</th>
                        <th>Direccion</th>
                        <th>Teléfono</th>
                        <th>Tipo Sangre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->user->name }}</td>
                        <td>{{ $patient->birth_date }}</td>
                        <td>{{ \Carbon\Carbon::parse($patient->birth_date)->age }}</td>
                        <td>{{ $patient->user->email }}</td>
                        <td>{{ $patient->user->address }}</td>
                        <td>{{ $patient->user->phone }}</td>
                        <td><span class="red_font">{{ $patient->bloodType->name }}</sapn></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$patient->id}}">
                                Ver Ficha
                            </button>
                           <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modificarModal-{{$patient->id}}">
                                Modificar
                            </button>

                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
                </tfoot>
            </table>
        </div>
      </div>
    </div>
  


<!-- Modal -->
@foreach ($patients as $patient)
<div class="modal fade" id="exampleModal-{{$patient->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ficha Paciente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
        <p><span class="fw-bold">Nombre:</span> {{ $patient->user->name }}</p>
        <p><span class="fw-bold">Fecha Nac.:</span> {{ $patient->birth_date }}</p>
        <p><span class="fw-bold">Edad:</span> {{ \Carbon\Carbon::parse($patient->birth_date)->age }}</p>
        <p><span class="fw-bold">Género:</span> {{ $patient->gender }}</p>

        <p><span class="fw-bold">Email:</span> {{ $patient->user->email }}</p>
        <p><span class="fw-bold">Dirección:</span> {{ $patient->user->address }}</p>
        <p><span class="fw-bold">Teléfono:</span> {{ $patient->user->phone }}</p>
        <p><span class="fw-bold">Tipo de Sangre:</span> {{ $patient->bloodType->name }} <span class="fw-bold">RH:</span> {{ $patient->rh }}</p>
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

@foreach ($patients as $patient)
<div class="modal fade" id="modificarModal-{{$patient->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ficha Paciente Modifica</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $patient->id }}"> 
          <p><span class="fw-bold">Nombre:<input type="text" name="name" class="form-control" value="{{ $patient->user->name }}"/></p>
          <p><span class="fw-bold">Fecha Nac.:<input type="date" name="birth_date" class="form-control" value="{{ $patient->birth_date }}"/></p>
          <p><span class="fw-bold">Edad: <input type="text" name="age" class="form-control" value="{{ \Carbon\Carbon::parse($patient->birth_date)->age }}" readonly/></p>
          <p><span class="fw-bold">Género:<select name="gender" class="form-control">
                                      <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Masculino</option>
                                      <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Femenino</option>
                                      <option value="Other" {{ $patient->gender == 'Other' ? 'selected' : '' }}>Otro</option>
                                  </select></p>

          <p><span class="fw-bold">Email:<input type="email" name="email" class="form-control" value="{{ $patient->user->email }}"/></p>
          <p><span class="fw-bold">Dirección:<input type="text" name="address" class="form-control" value="{{ $patient->user->address }}"/></p>
          <p><span class="fw-bold">Teléfono:<input type="text" name="phone" class="form-control" value="{{ $patient->user->phone }}"/></p>
          <p><span class="fw-bold">
              <div class="row">
                   <div class="col-6">
                Tipo de Sangre:<select name="bloodType" class="form-control">
                                      @foreach($bloodType as $type)
                                        <option value="{{ $type->id }}" {{ $patient->bloodType->id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                      @endforeach
                                </select>
                    </div>
                   <div class="col-6">
                   Factor Rh:<select name="rh" class="form-control">
                                      <option value="+" {{ $patient->rh == '+' ? 'selected' : '' }}>+</option>
                                      <option value="-" {{ $patient->rh == '-' ? 'selected' : '' }}>-</option>
                                  </select>
                    </div>                    
              </div>
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


 <!-- Modal Crear Paciente -->
 <div class="modal fade" id="modalCrearPaciente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear Paciente::</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
       <form action="{{ route('patients.store') }}" method="POST">
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
                  <label for="birth_date" class="form-label">Fecha Nac:</label>
                  <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="Fecha de Nacimiento" required>
                </div>

                 <div class="mb-3">
                  <label for="gender" class="form-label">Género:</label>
                  <select class="form-select" aria-label="Default select example" name="gender" required>
                    <option value="0" selected>Seleccione...</option>
                    <option value="Male">Masculino</option>
                    <option value="Female">Femenino</option>
                    <option value="Other">Otro</option>
                  </select>
                </div>
                <div class="mb-3">
                   <div class="row">
                       <div class="col-6">
                          <label for="email" class="form-label">Tipo de Sangre</label>
                          <select class="form-select" aria-label="Default select example" name="bloodType" required>
                            <option value="0" selected>Seleccione...</option>
                                @foreach($bloodType as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                          </select>
                       </div>
                       <div class="col-6">
                          <label for="rh" class="form-label">Factor Rh</label>
                          <select class="form-select" aria-label="Default select example" name="rh" required>
                            <option value="0" selected>Seleccione...</option>
                            <option value="+">+</option>
                            <option value="-">-</option>
                          </select>
                       </div>
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
                  <label for="allergies" class="form-label">Tipos de Alergias:</label>
                  <input type="text" class="form-control" id="allergies" name="allergies" placeholder="Tipos de Alergias" required>
                </div>

                <div class="mb-3">
                  <label for="condiciones" class="form-label">Condiciones cronicas:</label>
                  <input type="text" class="form-control" id="chronics_conditions" name="chronics_conditions" placeholder="Condiciones cronicas" required>
                </div>                      
                
                <div class="mb-3">
                  <label for="observations" class="form-label">Observaciones:</label>
                  <textarea rows="3" name="observations" class="form-control" id="observations" placeholder="Observaciones"></textarea>

                </div>                                       
                
                <div class="mb-3">
                  <label for="emergency_contact_name" class="form-label">Nombre contacto Emergencias:</label>
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


