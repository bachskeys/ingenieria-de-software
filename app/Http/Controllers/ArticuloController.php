<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Libro;
use App\Articulo;
use App\User;
class ArticuloController extends Controller
{
    //
    public function borrarArticulo(Request $request)
    {
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
    public function prestarArticuloEncargado(Request $request)
    {
         $identidad = $request->identidad;
         $id = $request->id;
         $articulos = Libro::find($id)->articulo;
         $userId = User::where('numeroIdentidad',"=",$identidad)->get()[0]->id;
         $user = User::find($userId);
         foreach($articulos as $articulo){
             $articuloId = $articulo->id;
            if(!$articulo->prestado && $articulo->utilizable){
                return $user->rentar($articuloId);
            }
         }
        
    }
    public function userPrestamos(Request $request)
    {
        $user_id = Auth::id();
        return User::find($user_id)->prestamosInfo();    
    }

    public function encargadoPrestamos(Request $request)
    {
        $identidad = $request->identidad;
        $user_id= User::where('numeroIdentidad',"=",$identidad)->get()[0]->id;
        return User::find($user_id)->prestamosInfo();    
    }
    public function encargadoEntregar(Request $request)
    {       $identidad = $request->identidad;
         $user_id= User::where('numeroIdentidad',"=",$identidad)->get()[0]->id;
         return User::find($user_id)->entregar($request);
    }
 }

