@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')

 <div class="row">
        <div class="col-8">
              <div class="card">
                    <div class="card-header">
                          AGENDA DOCTORES    - Patient_Id: {{ session('patient_id') }} - PatientName: {{ session('patientName')}}
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                     <form name="frmEspecialidad" action="{{ route('horasmedicas.doctores') }}" method="POST">
                                      @csrf
                                      <select name="especialidad" id="especialidad">
                                            <option value="0">Seleccione Especialidad</option>
                                            @foreach($especialidades as $especialidad)
                                                <option value="{{ $especialidad->id }}">{{ $especialidad->id }}-{{ $especialidad->name }}</option>
                                            @endforeach
                                      </select>
                                      @error('especialidad')
                                          <div class="alert alert-danger">{{ $message }}</div>
                                      @enderror
                                      <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
                                      <button id="miBoton" type="submit" class="btn btn-primary" disabled>Buscar</button>
                                      </form>

                                      <span id="selectedEspecialidad"></span>
                                </div>
                                <div class="col-6">
                                     <form action="">
                                      @csrf
                                      <select name="doctor" id="doctor">
                                            <option value="0">Seleccione Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->id }} - {{ $doctor->user->name }}</option>
                                            @endforeach
                                      </select>
                                       <button type="submit" class="btn btn-primary" >Buscar</button>
                                      </form>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                          <a href="#" class="btn btn-primary">Go somewhere</a>  
                    </div>

              </div>
        </div>
    </div>
    <script>
        document.getElementById('especialidad').addEventListener('change', function() {
            const select = document.getElementById('especialidad');
            const boton = document.getElementById('miBoton');
            if( select.value > 0 ) {
                boton.disabled = false;
            } else {
                boton.disabled = true;
            }

        });
    </script>


@endsection
