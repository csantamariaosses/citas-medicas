<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiTestController extends Controller
{
    public function index()
    {
        return view('admin.apitest.index');
    }

    
    public function apitest() {
        
        // Llamada directa a un endpoint abierto
        /*
        $response = Http::get('http://localhost:80/api/users');

         // Verificar si la petición fue exitosa (código 2xx)
        if ($response->successful()) {
            $datos = $response->json(); // Convierte la respuesta a array o JSON
            dd( $datos );
            //return view('usuarios.index', compact('datos'));
        }
            */

        // Llamada a un endpoint conseguridad
        // primero obtener el token via login
        $response = Http::post('http://localhost:80/api/login',  [
            'email' => 'tflores@gmail.com',
            'password' => 'password'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $token = $data['access_token'];
        
            $response = Http::withToken( $token )
            ->withHeaders(['Accept' => 'application/json'])
            ->post('http://localhost:80/api/infouser', [
                'email' => 'tflores@gmail.com'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $id = $data['id'];
                $name = $data['name'];
                $email = $data['email'];

                return view('admin.apitest.index', compact('data'));
                

            } else {
                dd("Error infouser ");
            }
                
            
        } else {
            dd("Error login");
        }
    }
    

}
