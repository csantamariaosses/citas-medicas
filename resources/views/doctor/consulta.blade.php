<!DOCTYPE html>
<html>
<head>
    <title>Factura</title>
    <style>
        body { font-family: sans-serif; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>Cita #{{ $citaId }}</h1>
    <p>Paciente: {{ $patientName }}</p>
    <p>Fecha: {{ $fecha }}</p>
    <p>Hora: {{ $hora }}</p>
    <p>Doctor: {{ $doctorName }}</p>
    <hr>
    <h4>Diadnostico:</h4>
    <p>{{ $diagnostic }}</p>
    <hr>
    <h4>Prescripciones:</h4>
     <p>{{ $prescriptions }}</p>
</body>
</html>