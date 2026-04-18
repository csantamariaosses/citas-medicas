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
                          AGENDA DOCTORES - Patient_id:{{ session('patient_id') }} - PatientName:{{ session('patientName') }}
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                     <form action="agendadoc.showcalendar" method="POST">
                                      @csrf
                                      <select name="doctor" id="doctor">
                                            <option value="0">Seleccione Medico</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->id }}-{{ $doctor->user->name }}</option>
                                            @endforeach
                                      </select>
                                      <input type="hidden" id="patient_id" name="patient_id" value="{{ session('patient_id') }}">
                                      <input type="hidden" id="specialityName" name="specialityName" value="{{ session('specialityName') }}">
                                      <button type="submit" class="btn btn-primary">Buscar</button>
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
@endsection