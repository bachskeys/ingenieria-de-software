<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Libro;
use App\Articulo;
use App\User;

class LibroController extends Controller
{
    public function crearLibro(Request $request){
        $libro = new Libro();
        $libro->titulo = $request->titulo;
        $libro->author = $request->author;
        $libro->descripcion = $request->descripcion;
        $libro->save();
        $libro->crearArticulo();
        return $libro;
    }
  
}

