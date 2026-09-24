@extends('layouts.app')
@section('menu')
  @include('menuadmin')
@endsection

@section('content')  
  
  <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h2>Gestor Bloqueo de Horarios Doctor</h2>
            <h3>{{ $doctor->user->name }}</h3>
            <p>https://www.udemy.com/course/crea-tu-sistema-de-citas-medicas-con-laravel/learn/lecture/51204183#overview</p>
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->
      <div class="row">
        <div class="col-12">  
           @livewire('admin.lockschedules-manager', ['doctor' => $doctor]) -->
        </div> <!-- col-md-6 offset-md-3 -->
      </div> <!-- row -->
  </div>  <!-- container --> 
@endsection
