@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')
    <h3>AGENDA DOC</h3>
    <div class="row">
    
         <!-- Primer Select -->
    <label>Estado / Provincia:</label>
   
    <!-- Segundo Select Anidado -->
    <label>Ciudad:</label>
  
    </div>

    <br><hr>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                        AGENDA DOCTORES  
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p>Aqui Componente de la Especialidad</p>
                            @livewire('Compouno')
                            
                        </div>
                        <div class="col-6">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('especialidad').addEventListener('change', function() {
            const select = document.getElementById('especialidad');
            const boton = document.getElementById('miBoton');
            if( select.value > 0 ) {
                boton.disabled = false;
            } else {
                boton.disabled = true;
            }

        });
    </script>

@endsection