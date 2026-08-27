@extends('layouts.app')
@section('menu')
  @include('menuadmin')
@endsection
@section('content')

  <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h1>Cambio de Password</h1>
            <p>Bienvenido a la página de Cambio de Password para Admin.</p>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('change-password-save') }}">
                        @csrf
    
                        <div class="form-group">
                            <label for="new_password">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                    </form>
                </div>
        </div>
    </div>    
   </div>
@endsection 
