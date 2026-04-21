@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')
    <livewire:admin.appointment-manager />
@endsection