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
                      <h3>Ver Paciente</h3>
              </div>
              <div class="card-body">
                  <form action="{{ route('patients.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="name" class="form-label">Nombre::</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="nombre" value="{{ $patient->user->name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email::</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="email"  value="{{ $patient->user->email }}" readonly  >
                        </div>

                        <div class="mb-3">
                          <label for="address" class="form-label">Dirección:</label>
                          <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="{{ $patient->user->address }}" readonly>
                        </div>

                        <div class="mb-3">
                          <label for="phone" class="form-label">Teléfono:</label>
                          <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" value="{{ $patient->user->phone }}" readonly>
                        </div>

                        <div class="mb-3">
                          <label for="email" class="form-label">Tipo de Sangre</label>
                          <input type="text" class="form-control" id="bloodType" name="bloodType" placeholder="Tipo de Sangre" value="{{ $patient->bloodType->name }}" readonly>

                        </div>

                        <div class="mb-3">
                          <label for="allergies" class="form-label">Tipos de Alergias:</label>
                          <input type="text" class="form-control" id="allergies" name="allergies" placeholder="Tipos de Alergias" value="{{ $patient->allergies }}" readonly>
                        </div>

                        <div class="mb-3">
                          <label for="condiciones" class="form-label">Condiciones cronicas:</label>
                          <input type="text" class="form-control" id="chronics_conditions" name="chronics_conditions" placeholder="Condiciones cronicas" value="{{ $patient->chronics_conditions }}" readonly>
                        </div>                      
                        
                        <div class="mb-3">
                          <label for="observations" class="form-label">Observaciones:</label>
                          <textarea rows="3" name="observations" class="form-control" id="observations" placeholder="Observaciones" readonly>{{ $patient->observations }}</textarea>

                        </div>                                       
                        
                        <div class="mb-3">
                          <label for="emergency_contact_name" class="form-label">Nombre contacto Emergencias:</label>
                          <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" placeholder="Nombre Contacto Emergencias" value="{{ $patient->emergency_contact_name }}" readonly>
                        </div>    

                      <div class="d-grid gap-2 d-md-block">
                        
                        <button class="btn btn-primary" type="button" onClick="window.history.back()">OK..</button>
                      </div>
                  </form>
              </div>     <!-- card-body -->       
            </div>  <!-- card -->
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->

      <div class="row mt-4">
        <div class="col-10 offset-2">  
          <h3>Información Adicional</h3>
        </div>
      <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Info Personal</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Info Clinica</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <div class="mb-3">
                          <label for="name" class="form-label">Nombre::</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="nombre" value="{{ $patient->user->name }}" readonly>
                        </div>
                        <div class="mb-3">
                          <label for="email" class="form-label">Email::</label>
                          <input type="email" class="form-control" id="email" name="email" placeholder="email"  value="{{ $patient->user->email }}" readonly  >
                        </div>

                        <div class="mb-3">
                          <label for="address" class="form-label">Dirección:</label>
                          <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="{{ $patient->user->address }}" readonly>
                        </div>
          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="mb-3">
                  <label for="email" class="form-label">Tipo de Sangre</label>
                  <input type="text" class="form-control" id="bloodType" name="bloodType" placeholder="Tipo de Sangre" value="{{ $patient->bloodType->name }}" readonly>

                </div>

                <div class="mb-3">
                  <label for="allergies" class="form-label">Tipos de Alergias:</label>
                  <input type="text" class="form-control" id="allergies" name="allergies" placeholder="Tipos de Alergias" value="{{ $patient->allergies }}" readonly>
                </div>

                <div class="mb-3">
                  <label for="condiciones" class="form-label">Condiciones cronicas:</label>
                  <input type="text" class="form-control" id="chronics_conditions" name="chronics_conditions" placeholder="Condiciones cronicas" value="{{ $patient->chronics_conditions }}" readonly>
                </div>            
          </div>
          <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            This is some placeholder content the Contact tab's associated content. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling. You can use it with tabs, pills, and any other .nav-powered navigation.
          </div>
        </div>
      </div> <!-- row -->
      <br><br>
  </div>  <!-- container --> 
  @endsection
