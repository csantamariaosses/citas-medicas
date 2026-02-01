<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiProductosController;    

Route::get('/prueba', function (Request $request) {
    return "Esta es una ruta de prueba"; 
});

Route::get('/productos', [ApiProductosController::class, 'index']);


Route::post('/productos', function (Request $request) {
    return "Creando Producto"; 
});

Route::put('/productos/{id}', function (Request $request) {
    return "Actualizando Producto"; 
});



Route::delete('/productos/{id}', [ApiProductosController::class, 'destroy']);

