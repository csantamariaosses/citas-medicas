<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;

class ApiProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'message' => 'API funcionando correctamente'
        ];
        $productos = \App\Models\Producto::all();
        $data['datos'] = $productos;
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        if( \App\Models\Producto::destroy($id) ) {
            session()->flash( 'swal' , [
                'title' => 'Producto eliminado',
                'text' => 'El producto ha sido eliminado con exito',
                'icon' => 'success',
                //'timer' => 3000,
                'showConfirmButton' => false
            ]);

            return redirect()->route('productos.index');

        } 

        

        $data = [
            'message' => 'ocurrio un error al eliminar el producto'
        ];

        return response()->json($data, 200);
    }
}
