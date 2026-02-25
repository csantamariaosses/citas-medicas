@extends('layouts.app')
@section('menu')
  @include('menu')
@endsection

@section('content')  
  
  <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">  
            <div class="card">
              <div class="card-head">
                      <h3>Modificar Doctores</h3>
              </div>
              <div class="card-body">
                  <form action="{{ route('doctores.update', $id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="name" class="form-label">Nombre::</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="nombre" value="{{ $doctor->user->name }}" >
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email::</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="email"  value="{{ $doctor->user->email }}">
                        </div>

                        <div class="mb-3">
                          <label for="address" class="form-label">Dirección:</label>
                          <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="{{ $doctor->user->address }}" required>
                        </div>

                        <div class="mb-3">
                          <label for="phone" class="form-label">Teléfono:</label>
                          <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" value="{{ $doctor->user->phone }}">
                        </div>

                         <div class="mb-3">
                          <label for="rol" class="form-label">Rol:</label>
                          <select name="role" id="role" class="form-control">
                            @foreach($roles as $role)
                              <option value="{{ $role->id }}" {{ $doctor->user->roles->first()->id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label for="speciality" class="form-label">Especialidad:</label>
                          <select name="speciality" id="speciality" class="form-control">
                            @foreach($specialities as $speciality)
                              <option value="{{ $speciality->id }}" {{ $doctor->speciality_id == $speciality->id ? 'selected' : '' }}>{{ $speciality->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label for="medical_license_number" class="form-label">Licencia Médica:</label>
                          <input type="text" class="form-control" id="medical_license_number" name="medical_license_number" placeholder="Licencia Médica" value="{{ $doctor->medical_license_number }}">
                        </div>

                        <div class="mb-3">
                          <label for="observations" class="form-label">Observaciones:</label>
                          <textarea rows="3" name="observations" class="form-control" id="observations" placeholder="Observaciones">{{ $doctor->observations }}</textarea>

                        </div>                                       
                        
                        <div class="mb-3">
                          <label for="emergency_contact_name" class="form-label">Nombre contacto Emergencias:</label>
                          <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" placeholder="Nombre Contacto Emergencias" value="{{ $doctor->emergency_contact_name }}">
                        </div>    

                      <div class="mb-3">
                          <label for="active" class="form-label">Activo:</label>
                          <select name="active" id="active" class="form-control">
                            <option value="1" {{ $doctor->active ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ !$doctor->active ? 'selected' : '' }}>No</option>
                          </select>
                        </div>

                      <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="submit">Guardar</button>
                        <button class="btn btn-primary" type="button" onClick="window.history.back()">Cancelar</button>

                      </div>
                  </form>
              </div>     <!-- card-body -->       
            </div>  <!-- card -->
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->
  </div>  <!-- container --> 
  @endsection
