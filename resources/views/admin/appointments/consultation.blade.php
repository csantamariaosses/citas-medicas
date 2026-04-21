@extends('layouts.app')
@section('menuadmin')
  @include('menu')
@endsection

@section('content')  
      <livewire:admin.consultation-manager :appointment="$appointment"/>
@endsection