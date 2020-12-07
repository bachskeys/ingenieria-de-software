<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revista extends Model
{
    public function articulo(){
        return $this->morphMany('App\articulo','prestable');
    }
    public function crearArticulo(){
        $articulo = new Articulo();
        $this->articulo()->save($articulo);
    }
    
}
