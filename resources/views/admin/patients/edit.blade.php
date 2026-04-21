@extends('layouts.app')
@section('menu')
  @include('menuadmin')
@endsection

@section('content')  
  
  <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">  
            <div class="card">
              <div class="card-head">
                      <h3>Modificar Paciente</h3>
              </div>
              <div class="card-body">
                  <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="name" class="form-label">Nombre::</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="nombre" value="{{ $patient->user->name }}" >
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email::</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="email"  value="{{ $patient->user->email }}">
                        </div>

                        <div class="mb-3">
                          <label for="address" class="form-label">Dirección:</label>
                          <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="{{ $patient->user->address }}" required>
                        </div>

                        <div class="mb-3">
                          <label for="phone" class="form-label">Teléfono:</label>
                          <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" value="{{ $patient->user->phone }}">
                        </div>

                        <div class="mb-3">
                          <label for="email" class="form-label">Tipo de Sangre {{ $patient->blood_type }}</label>
                          
                           <select class="form-select" aria-label="Default select example" name="bloodType" required>
                              
                              @foreach($bloodType as $type)
                                @if( $type->name == $patient->blood_type )
                                  <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                @else     
                                  <option value="{{ $type->id }}">{{ $type->name }}</option>  
                                @endif
                              @endforeach
                          </select>

                        </div>

                        <div class="mb-3">
                          <label for="allergies" class="form-label">Tipos de Alergias:</label>
                          <input type="text" class="form-control" id="allergies" name="allergies" placeholder="Tipos de Alergias" value="{{ $patient->allergies }}" required>
                        </div>

                        <div class="mb-3">
                          <label for="condiciones" class="form-label">Condiciones cronicas:</label>
                          <input type="text" class="form-control" id="chronics_conditions" name="chronics_conditions" placeholder="Condiciones cronicas" value="{{ $patient->chronics_conditions }}" required>
                        </div>                      
                        
                        <div class="mb-3">
                          <label for="observations" class="form-label">Observaciones:</label>
                          <textarea rows="3" name="observations" class="form-control" id="observations" placeholder="Observaciones">{{ $patient->observations }}</textarea>

                        </div>                                       
                        
                        <div class="mb-3">
                          <label for="emergency_contact_name" class="form-label">Nombre contacto Emergencias:</label>
                          <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" placeholder="Nombre Contacto Emergencias" value="{{ $patient->emergency_contact_name }}">
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
