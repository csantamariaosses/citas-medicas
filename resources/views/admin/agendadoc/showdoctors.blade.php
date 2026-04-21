@extends('layouts.app') 

@section('menu')
<<<<<<< HEAD
  @include('menuadmin')
=======
  @include('menu')
>>>>>>> 5033bce6b1cb0930b50305631c7b91376bc765e2
@endsection

@section('content')
    <h3>AGENDA DOC</h3>

    <div class="row">
        <div class="col-8">
              <div class="card">
                    <div class="card-header">
                          AGENDA DOCTORES - Patient_id:{{ session('patient_id') }} - PatientName:{{ session('patientName') }}
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-6">
<<<<<<< HEAD
                                     <form action="{{ route('horasmedicas.showcalendar') }}" method="POST">
                                      @csrf
                                      @method('POST')
                                      <select name="doctor" id="doctor">
                                            <option value="0">Seleccione Medico::</option>
=======
                                     <form action="agendadoc.showcalendar" method="POST">
                                      @csrf
                                      <select name="doctor" id="doctor">
                                            <option value="0">Seleccione Medico</option>
>>>>>>> 5033bce6b1cb0930b50305631c7b91376bc765e2
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->id }}-{{ $doctor->user->name }}</option>
                                            @endforeach
                                      </select>
<<<<<<< HEAD
                                       @error('doctor')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                       @enderror

                                      <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
                                      <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">
                                      <button id="miBoton" type="submit" class="btn btn-primary" disabled>Buscar</button>
=======
                                      <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
                                      <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">
                                      <button type="submit" class="btn btn-primary">Buscar</button>
>>>>>>> 5033bce6b1cb0930b50305631c7b91376bc765e2
                                      </form>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
<<<<<<< HEAD
                        
=======
                          <a href="#" class="btn btn-primary">Go somewhere</a>  
>>>>>>> 5033bce6b1cb0930b50305631c7b91376bc765e2
                    </div>

              </div>
        </div>
    </div>
<<<<<<< HEAD
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
=======
>>>>>>> 5033bce6b1cb0930b50305631c7b91376bc765e2
@endsection