@extends('layouts.app') 

@section('menu')
  @include('menu')
@endsection

@section('content')

   <div class="container">
   
   </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">  
      <h3>Productos</h3>
        <a href="{{ route('productos.create') }}">Crear Producto</a>
        <table border="1">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Precio</th>
              <th>Stock</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($productos as $producto)
            <tr>
              <td>{{ $producto->id }}</td>
              <td>{{ $producto->nombre }}</td>
              <td>{{ $producto->descripcion }}</td>
              <td>{{ $producto->precio }}</td>
              <td>{{ $producto->stock }}</td>
              <td>
                <a href="{{ route('productos.show', $producto->id) }}">Ver</a>
                <a href="{{ route('productos.edit', $producto->id) }}">Editar</a>

                <form action="{{ route('productos.destroy', $producto->id) }}" 
                  method="POST" 
                  style="display:inline;"
                  class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div>
    </div>
@endsection


