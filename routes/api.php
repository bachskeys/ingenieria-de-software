<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user/prestar/{id}','ArticuloController@prestarArticuloUsuario');


    Route::get('/users', function () {
        return App\User::all();
    });
    Route::post('crear/libro','LibroController@crearLibro');
    Route::post('crear/revista','RevistaController@crearRevista');
    Route::post('/prestar','ArticuloController@prestarArticuloEncargado');
    Route::get('/libros','LibroController@getAllLibros');
    Route::get('/user/prestamos','ArticuloController@userPrestamos');
    Route::post('/encargado/prestamos','ArticuloController@encargadoPrestamos');
    Route::post('/encargado-prestamos','ArticuloController@encargadoPrestamos');
    Route::post('/encargado-entregar','ArticuloController@encargadoEntregar');




    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('/encargado/prestar','ArticuloController@prestarArticuloEncargado');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
    Route::post('borrar/articulo','ArticuloController@borrarArticulo');

});
