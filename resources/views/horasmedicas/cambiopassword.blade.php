@extends('layouts.app') 

@section('menu')
  @include('menupatient')
@endsection

@section('content')
    <h3>CAMBIO PASSWORD</h3>

    <div class="row">
        <div class="col-8">
              <div class="card">
                    <div class="card-header">
                          CAMBIO PASSWORD - Patient_id:{{ session('patient_id') }} -  User_id:{{ session('user_id') }} - PatientName:{{ session('patientName') }}
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                     <form action="{{ route('horasmedicas.cambiopasswordsave') }}" method="POST">
                                      @csrf
                                      @method('POST')
                                      <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password:</label>
                                        <input type="password" class="form-control" id="new_password"  placeholder="Enter new password" name="new_password" value="password" required>
                                      </div>

                                      <input type="hidden" id="user_id" name="user_id" value="{{ session('user_id') }}">
                                      <button id="miBoton" type="submit" class="btn btn-primary">Guardar</button>
                                      </form>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        
                    </div>

              </div>
        </div>
    </div>
@endsection