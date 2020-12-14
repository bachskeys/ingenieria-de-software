<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Revista;
use App\Articulo;
use App\User;

class RevistaController extends Controller
{
    public function crearRevista(Request $request){
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
        $revista = new Revista();
        $revista->titulo = $request->titulo;
        $revista->descripcion = $request->descripcion;
        $revista->save();
        for ($i = 1; $i <= $copias; $i++) {
            $revista->crearArticulo();
        }
        return $revista;
    }
  
}
