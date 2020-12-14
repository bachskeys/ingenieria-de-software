<?php

namespace App;

use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Prestamo;
use Carbon\Carbon;
use App\Articulo;
use App\Incidencia;

class User extends Authenticatable implements JWTSubject //, MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',"telefono","direccion",'numeroIdentidad'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url',
    ];
    
    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function incidencias(){
        return $this->hasMany('App\Indicencia','user_id');
    }

    public function prestamos(){
         return $this->hasMany('App\Prestamo','user_id');

    }
    public function prestamosInfo(){
        $prestamos = $this->prestamos;
        $prestamosArray =[];
        foreach($prestamos as $prestamo){
            if($prestamo->status){
                $libro = Articulo::find($prestamo->articulo_id)->prestable;
                $item= new \stdClass();
                $item->prestamo_id = $prestamo->id;
                $item->fecha_entrega = $prestamo->Fecha_entrega;
                $item->fecha_prestamo = $prestamo->Fecha_prestamo;
                $item->articulo_id = $prestamo->articulo_id;
                $item->libro_id = $libro->id;
                $item->titulo = $libro->titulo;
                $item->author = $libro->author;
                $item->descripcion = $libro->descripcion;
                 array_push($prestamosArray,$item);
            }
        }
        return $prestamosArray;
    }
    public function generarIncidencia($entregaInfo){
        $incidencia= (object) $entregaInfo->incidencia;
        $prestamo = (object) $entregaInfo->prestamo;
        $articulo_id = $prestamo->articulo_id;
        $Incidencia = new Incidencia();
        $Incidencia->user_id = $this->id;
        $Incidencia->articulo_id = $articulo_id;
        $Incidencia->descripcion = $incidencia->descripcion;
        if($incidencia->obsoleto){
            $articulo = Articulo::find($articulo_id);
            $articulo->utilizable = false;
            $articulo->save();
        }
        $save = $Incidencia->save();
        if($save){
            return json_encode("Incidencia creada con exito");
        }
        return json_encode("hubo un error al generar la Incidencia");


    }
    public function rentar($articuloId){
        $articulo = Articulo::find($articuloId);
        $prestamo = new Prestamo();
        $prestamo->user_id = $this->id;
        $prestamo->articulo_id = $articuloId;
        $prestamo->status = true;
        $prestamo->Fecha_prestamo=Carbon::now();
        $prestamo->Fecha_entrega=Carbon::now()->addDays(3);
        $save = $prestamo->save();
        if($save){
            $articulo->prestado=true;
            $articuloSaved =$articulo->save();
            if($articuloSaved){
                return json_encode("libro prestado con exito con exito");
            }
        }
        return json_encode('hubo un error al prestar el libro');

    }
    public function entregar($entregaInfo){
        $prestamo = (object) $entregaInfo->prestamo;
       // return $entregaInfo->incidencia;
        $incidencia = (object) $entregaInfo->incidencia;
        $articulo_id = $prestamo->articulo_id;
        $prestamo_id = $prestamo->prestamo_id;
        $prestamoModel = Prestamo::find($prestamo_id);
        $prestamoModel->Fecha_entregado = Carbon::now(); 
        $prestamoModel->status = false;
        $prestamoModel->save();
        $articulo = Articulo::find($articulo_id);
        $articulo->prestado = false;
        $articulo->save();
        if($incidencia->has){
           return $this->generarIncidencia($entregaInfo);
        }
        return json_encode('se entrego el articulo sin ninguna incidencia');
    }

}
