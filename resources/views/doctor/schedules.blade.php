@extends('layouts.app')

@section('menu')
  @include('menudoctor')  
@endsection

@section('content')
<style>
    .color-green {
        color: #008000;
    }
    .color-red {
        color: #ff0000;
    }
    .color-blue {
        color: #0000ff;
    }
    .color-orange {
        color: #ffa500;
    }
    .color-brown {
        color: #97660a;
    }
</style>
    <div class="row">
        <div class="col-10 offset-2">  
          <h3>Doctor Schedules</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-3">  
            <div class="card">
                <div class="card-header">
                    Doctor Information
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $doctor->user->name }}</h5>
                    <p class="card-text">Specialidad: {{ $doctor->speciality->name }}<br>  
                    <span class="card-text">Email: {{ $doctor->user->email }}</span></p>
                </div>
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-3">  
            Scheules:
             @livewire('admin.schedule-manager', ['doctor' => $doctor]) 
        </div>
     </div>

@endsection


