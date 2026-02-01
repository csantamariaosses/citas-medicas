<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <h3>Editar Producto</h3>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-6 offset-md-3">  
            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="{{ $producto->nombre }}">
              </div>
              <div class="mb-3">
                  <label for="precio" class="form-label">Precio</label>
                  <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio" value="{{ $producto->precio }}">
              </div>

              <div class="mb-3">
                  <label for="descripcion" class="form-label">Descripción</label><br>
                  <textarea id="descripcion" name="descripcion" cols="50" rows="5" required>{{ $producto->descripcion }}</textarea>
              </div>

              <button class="btn btn-success" type="submit">Actualizar</button>
              <button class="btn btn-secondary" type="button" onclick="window.history.back();">Cancelar</button>
            </form> 
        </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>