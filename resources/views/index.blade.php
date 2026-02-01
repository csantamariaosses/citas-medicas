@extends('layouts.app')
@section('menu')
  @include('menu')
@endsection
@section('content')

  <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h1>Index</h1>
            <ul>
              <li><a href="{{ route('productos.index') }}">Producto....</a></li>
              <li><a href="{{ route('users.index') }}">Usuarios</a></li>
            </ul>
        </div>
    </div>    
   </div>
@endsection 
