@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')
    <h3>AGENDA DOC</h3>

    <div class="row">
        <div class="col-8">
              <div class="card">
                    <div class="card-header">
                          AGENDA DOCTORES - Patient_id:{{ session('patient_id') }} - PatientName:{{ session('patientName') }} - SpecialityName: {{ session('specialityName') }}

                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                     <form action="{{ route('horasmedicas.showcalendar') }}" method="POST">
                                      @csrf
                                      @method('POST')
                                      <select name="doctor" id="doctor">
                                            <option value="0">Seleccione Medico::</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->id }}-{{ $doctor->user->name }}</option>
                                            @endforeach
                                      </select>
                                       @error('doctor')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                       @enderror

                                      <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
                                      <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">
                                      <button id="miBoton" type="submit" class="btn btn-primary" disabled>Buscar</button>
                                      </form>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        
                    </div>

              </div>
        </div>
    </div>
    <script>
        document.getElementById('doctor').addEventListener('change', function() {
            const select = document.getElementById('doctor');
            const boton = document.getElementById('miBoton');
            if( select.value > 0 ) {
                boton.disabled = false;
            } else {
                boton.disabled = true;
            }
           // document.querySelector('button[type="submit"]').disabled = false;
        });
    </script>
@endsection