@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')

    <div class="container">
  
        <div class="row">
        <div class="col-md-4 offset-md-2">  
             <div class="card">
                <div class="card-header">Registro</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('saveregister') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required autofocus value="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="password">
                        </div>
                        <div class="mb-3">
                            <label for="userType" class="form-label">Tipo de Usuario</label>
                            <select name="role" class="form-control">
                               <option value="0">Seleccione...</option>
                               @foreach( $roles as $role )
                                    <option value="{{$role->id}}">{{ $role->name }}</option>
                               @endforeach
                            </select>
                        </div>
                         <a href="{{ route('home') }}" button type="button" class="btn btn-primary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
              </div>
       
        <div>
    </div>


@endsection
