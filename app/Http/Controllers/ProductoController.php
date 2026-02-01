<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Session;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $productos = Producto::all();           
       
        //return "Hola desde el controlador de productos";    
        return view("productos.index", compact("productos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("productos.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd( $request );
        $producto = new Producto();
        $producto->nombre = $request->input("nombre");
        $producto->precio = $request->input("precio");
        $producto->descripcion = $request->input("descripcion");
        $producto->save();

        session()->flash( 'swal' , [
            'title' => 'Producto creado',
            'text' => 'El producto ha sido creado con exito',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        return redirect()->route("productos.index");    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $producto = Producto::findOrFail($id);
        return view("productos.show", compact("producto"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Producto::findOrFail($id);
        return view("productos.edit", ["producto" => Producto::findOrFail($id)]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->input("nombre");
        $producto->precio = $request->input("precio");
        $producto->descripcion = $request->input("descripcion");
        $producto->save();

        session()->flash( 'swal' , [
            'title' => 'Producto actualizado',
            'text' => 'El producto ha sido actualizado con exito',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        return redirect()->route("productos.index");        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
 
        $producto = Producto::findOrFail($id);
        $producto->delete();

        session()->flash( 'swal' , [
            'title' => 'Producto eliminado',
            'text' => 'El producto ha sido eliminado con exito',
            'icon' => 'success',
            //'timer' => 3000,
            'showConfirmButton' => 'Ok'
        ]); 

        return redirect()->route("productos.index");    
    }
}
