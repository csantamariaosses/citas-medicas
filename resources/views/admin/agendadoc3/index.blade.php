@extends('layouts.app') 

@section('menu')
  @include('menuadmin')
@endsection

@section('content')

<!-- Select de Estados o Categoría Padre -->
<div class="container">
    <form name="selectDoctor" action="{{ route('agendadoc3.showcalendar') }}" method="post">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="especialidades">Especialidades:</label>
                    <select name="speciality" id="speciality" class="form-control">
                        <option value="">Seleccione una especialidad</option>
                        @foreach($specialities as $speciality)
                            <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> <!-- Cierre de la fila -->
        <div class="row">
        <div class="col-3">
                <!-- Select Anidado de Especialidad y Doctores -->
                <div class="form-group">
                    <label for="doctor">Doctor:</label>
                    <select name="doctor" id="doctor" class="form-control">
                        <option value="">Seleccione un doctor</option>
                    </select>
                </div>
            </div>
        </div> <!-- Cierre de la fila -->
        <div class="row">
        <div class="col-3 d-grid">
              <button type="submit" class="btn btn-primary btn-l"  disabled>Consultar</button>
        </div>
    </form>
</div> <!-- Cierre del contenedor -->

<!-- Cargar jQuery -->
<script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
    integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
</script>


<script>
$(document).ready(function () {
    $('#doctor').val(); // Inicializar el valor del select de doctores como vacío
    console.log('Valor inicial del select de doctores:', $('#doctor').val()); // Verificar el valor inicial del select de doctores
    $('#speciality').on('change', function () {
        var specialityId = $(this).val();
        
        // Vaciar y deshabilitar el segundo select si no hay selección
        $('#doctor').empty().append('<option value="">Seleccione un doctor</option>');
        
        if (specialityId) {
            $.ajax({
                url: '/api/doctores/' + specialityId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Recorrer los datos recibidos y agregarlos al select
                    $.each(data, function (key, value) {
                        $('#doctor').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                },
                error: function () {
                    alert('Error al cargar los doctores.');
                }
            });
        }
    });

    $('#doctor').on('change', function () {
        var doctorId = $(this).val();
        console.log('Valor seleccionado del select de doctores:', doctorId); // Verificar el valor seleccionado del select de doctores
        if (doctorId) {
            $('button[type="submit"]').prop('disabled', false);
        } else {
            $('button[type="submit"]').prop('disabled', true);
        }
    });
});

</script>
@endsection()