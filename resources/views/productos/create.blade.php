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
            <p>Versión de Laravel: </p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 offset-md-3">  
            <div class="card">
              <div class="card-head">
                      <h3>Crear Producto</h3>
              </div>
            <div class="card-body">
                <form action="{{ route('productos.store') }}" method="POST">
                      @csrf
                      <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre::</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre">
                      </div>

                      <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" placeholder="precio">
                      </div>

                      <div class="mb-3">
                          <label for="descripcion" class="form-label">descripcion</label>
                          <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                      
                    <div class="d-grid gap-2 d-md-block">
                      <button class="btn btn-primary" type="submit">Crear</button>
                      <button class="btn btn-primary" type="button" onClick="window.history.back()">Cancelar</button>
                  </div>
                </form>
            </div>            
          </div>
      </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>