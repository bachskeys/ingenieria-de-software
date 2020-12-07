<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Articulo;
class Libro extends Model
{
    public function articulo(){
        return $this->morphMany('App\articulo','prestable');
    }

    
    public function crearArticulo(){
        $articulo = new Articulo();
        $this->articulo()->save($articulo);
    } 
}
