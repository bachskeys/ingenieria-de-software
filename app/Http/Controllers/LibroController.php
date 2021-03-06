<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Libro;
use App\Articulo;
use App\User;

class LibroController extends Controller
{
    public function crearLibro(Request $request){
        // then put that name to $photoName variable.
        $photoName = '';
      if($request->file('imagen')){
        $imagen = $request->file('imagen');
        $photoName = time().'.'.$imagen->getClientOriginalExtension();

        /*
        talk the select file and move it public directory and make avatars
        folder if doesn't exsit then give it that unique name.
        */
        $imagen->move(public_path('libros'), $photoName);
      }
   
        (int)$copias = $request->copias;
        $libro = new Libro();
        $libro->titulo = $request->titulo;
        $libro->author = $request->author;
        $libro->descripcion = $request->descripcion;
        $libro->imagen = $photoName;
        $libro->save();
        for ($i = 1; $i <= $copias; $i++) {
            $libro->crearArticulo();
        }
        return $libro;
    }
    public function getAllLibros(){
        $models = Libro::All();
        $models->each(function ($item){
           return $item->copiasDisponibles();
        });
       return $models;
    }
  
}

