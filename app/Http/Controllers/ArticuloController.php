<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\User;
class ArticuloController extends Controller
{
    //
    public function borrarArticulo(Request $request){
        $articulo_id = $request->articulo_id;
        $articulo = Articulo::find($articulo_id);
        if($articulo){
            return json_encode($articulo->borraArticulo());
        }
        return json_encode('el articulo no existe');
    }
    public function prestarArticuloUsuario(Request $request,$articulo_id){
        $user_id = $request->user()->id;
        return User::find($user_id)->rentar($articulo_id);
    }
    public function prestarArticuloEncargado(Request $request){
        $user_id = $request->user_id;
        $articulo_id = $request->articulo_id;
        return User::find($user_id)->rentar($articulo_id);
    }
 }

