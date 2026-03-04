@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')
    <livewire:admin.appointment-manager />
@endsection