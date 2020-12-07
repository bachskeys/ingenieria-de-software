<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articulo extends Model
{
    use softDeletes;
    public function prestable(){
        return $this->morphTo();
    }
    public function borraArticulo(){
        $this->delete();
        if($this->trashed()){
            return 'el articulo fue borrado con exito';
        }
        return 'hubo un error al borrar el artiuclo';
    }
}
