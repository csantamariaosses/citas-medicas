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
          <h3>Usuarios::</h3>
          <!--https://datatables-net.translate.goog/extensions/buttons/examples/initialisation/export.html?_x_tr_sl=en&_x_tr_tl=es&_x_tr_hl=es&_x_tr_pto=tc -->
        </div>
    </div>

     <div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Usuario</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPaciente">
                                Crear Usuario Modal
                            </button>
     </div>
      <hr>
      <div class="row">
        <div class="col-10">
            <table id="example" class="display nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verModal-{{$user->id}}">
                                Ver Info
                            </button>
                           <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modificarModal-{{$user->id}}">
                                Modificar
                            </button>

                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Roles</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
      </div>
    </div>
  


<!-- Modal -->
@foreach ($users as $user)
<div class="modal fade" id="verModal-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ficha Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <p><span class="fw-bold">Nombre:</span> {{ $user->name }}</p>
        <p><span class="fw-bold">Email:</span> {{ $user->email }}</p>
        <p><span class="fw-bold">Dirección:</span> {{ $user->address }}</p>
        <p><span class="fw-bold">Teléfono:</span> {{ $user->phone }}</p>

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


 <!-- Modal Modificar  -->

@foreach ($users as $user)
<div class="modal fade" id="modificarModal-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ficha Usuario Modifica</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $user->id }}"> 
          <p><span class="fw-bold">Nombre:<input type="text" name="name" class="form-control" value="{{ $user->name }}"/></p>
          <p><span class="fw-bold">Email:<input type="email" name="email" class="form-control" value="{{ $user->email }}"/></p>
          <p><span class="fw-bold">Dirección:<input type="text" name="address" class="form-control" value="{{ $user->address }}"/></p>
          <p><span class="fw-bold">Teléfono:<input type="text" name="phone" class="form-control" value="{{ $user->phone }}"/></p>
          <p><span class="fw-bold">Género:<select name="gender" class="form-control">
                                      <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Masculino</option>
                                      <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Femenino</option>
                                      <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Otro</option>
                                  </select></p>

          <p><span class="fw-bold">Email:<input type="email" name="email" class="form-control" value="{{ $user->email }}"/></p>
          <p><span class="fw-bold">Dirección:<input type="text" name="address" class="form-control" value="{{ $user->address }}"/></p>
          <p><span class="fw-bold">Teléfono:<input type="text" name="phone" class="form-control" value="{{ $user->phone }}"/></p>

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
        <h5 class="modal-title" id="exampleModalLabel">Crear Usuario::</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
       <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nombre:</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="nombre" required>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email:</label>
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
                  <label for="condiciones" class="form-label">Condiciones crónicas:</label>
                  <input type="text" class="form-control" id="chronics_conditions" name="chronics_conditions" placeholder="Condiciones crónicas" required>
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


