@extends('layouts.app')
@section('menu')
  @include('menu')
@endsection

@section('content')  
  
  <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h2>Gestor de Horarios Doctor</h2>
            <h3>{{ $doctor->user->name }}</h3>
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->
      <div class="row">
        <div class="col-12">  
            @livewire('admin.schedule-manager', ['doctor' => $doctor])
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->
  </div>  <!-- container --> 
@endsection
