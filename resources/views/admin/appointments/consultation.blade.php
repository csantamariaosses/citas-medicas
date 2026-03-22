@extends('layouts.app')
@section('menu')
  @include('menu')
@endsection

@section('content')  
      <livewire:admin.consultation-manager :appointment="$appointment"/>
@endsection