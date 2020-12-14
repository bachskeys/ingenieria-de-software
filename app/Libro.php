<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Articulo;
class Libro extends Model
{
    public function articulo(){
        return $this->morphMany('App\articulo','prestable');
    }
    public function copiasDisponibles(){
        $articulos = $this->articulo()->pluck('prestado')->toArray();
        $articulosUtilizables = $this->articulo()->pluck('utilizable')->toArray();
        if(in_array(false,$articulos)){
            if(in_array(true,$articulosUtilizables)){
                $this->copias=true;
                $this->save();
                error_log('existen copias');
                return "existen copias";
            }
        }else{
            $this->copias=false;
            $this->save();
            error_log('no existen copias');
            return "no existen copias disponibles";
        }
    }
    
    public function crearArticulo(){
        $articulo = new Articulo();
        $this->articulo()->save($articulo);
    } 
}
