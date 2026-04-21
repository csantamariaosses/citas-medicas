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
                      <h3>Crear Doctores</h3>
              </div>
              <div class="card-body">
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
                          <label for="email" class="form-label">Rol</label>
                          <select class="form-select" aria-label="Default select example" name="role" required>
                              <option value="0" selected>Seleccione...</option>
                            @foreach($roles as $r)
                              <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label for="email" class="form-label">Especialidad</label>
                          <select class="form-select" aria-label="Default select example" name="speciality" required>
                              <option value="0" selected>Seleccione...</option>
                            @foreach($specialities as $s)
                              <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                          </select>
                        </div>


                        <div class="mb-3">
                          <label for="observations" class="form-label">Observaciones:</label>
                          <textarea rows="3" name="observations" class="form-control" id="observations" placeholder="Observaciones"></textarea>

                        </div>                                       
                        
                        <div class="mb-3">
                          <label for="emergency_contact_name" class="form-label">Nombre contacto Emergencias:</label>
                          <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" placeholder="Nombre Contacto Emergencias" required>
                        </div>    

                         <div class="mb-3">
                          <label for="medical_license_number" class="form-label">Número de licencia médica:</label>
                          <input type="text" class="form-control" id="medical_license_number" name="medical_license_number" placeholder="Número de licencia médica" required>
                        </div> 

                      <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="submit">Crear</button>
                        <button class="btn btn-primary" type="button" onClick="window.history.back()">Cancelar</button>
                      </div>
                  </form>
              </div>     <!-- card-body -->       
            </div>  <!-- card -->
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->
  </div>  <!-- container --> 
  @endsection
