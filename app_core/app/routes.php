<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * User login
 */
Route::get('login', 'UserController@getLogin');
Route::post('login', 'UserController@postLogin');

/**
 * Usuario logueado
 */
Route::group(array( 'before' => 'auth' ), function () {

    Route::get('/', function () { return View::make('home'); });

    route::get('profile', 'UserController@getProfile');
    route::post('profile', 'UserController@postProfile');

    Route::get('logout', 'UserController@getLogout');

    /**
     * Usuario logueado con permiso hoja-diaria
     */
    Route::group(array( 'before' => 'hasAccess:hoja-diaria' ), function () {

        /**
         * Hoja Diaria
         */
        Route::resource('hd', 'HojaDiariaController');

        /**
         * Block
         */
        Route::get('/block/ajax-blocks/{idSector}', 'BlockController@ajaxBlocks');
        Route::get('/block/ajax-block-todo/{idBlock}', 'BlockController@ajaxBlockTodo');
        Route::get('/block/ajax-get-limites/{data}', 'BlockController@ajaxGetLimites');
        Route::get('/block/{id}/desviadores', 'BlockController@getDesviadores');

        /**
         * Desviador
         */
        Route::get('/desviador/ajax-desviadores/{blockId}', 'DesviadorController@ajaxDesviadores');
        Route::get('/desviador/get-desviadores-sur/{id}', 'DesviadorController@getDesviadoresSur');

        /**
         * Material Retirado
         */
        Route::get('material-retirado/ajax-list', 'MaterialRetiradoController@ajaxList');

    });

    /**
     * Usuario logueado con permisos de creación en form hoja diaria
     */
    Route::group(array( 'before' => 'hasAccess:editor' ), function () {
        /**
         * Creación de desviador
         */
        Route::post('/desviador/ajax-create', 'DesviadorController@ajaxCreate');

        /**
         * Creación de desvio
         */
        Route::post('desvio', 'DesvioController@store');

        /**
         * Creación de material retirado
         */
        Route::post('material-retirado', 'MaterialRetiradoController@store');

        /**
         * Creación de colocado
         */
        Route::post('material-colocado', 'MaterialController@store');

        /**
         * Creación de trabajo
         */
        Route::post('trabajo', 'TrabajoController@store');
    });

    /**
     * Usuario logueado con permisos para consultas/reportes
     */
    Route::group(array( 'before' => 'hasAccess:reporte' ), function () {
        /**
         * Rutas para generar reportes
         */
        Route::get('/r/param', 'ReporteController@param');
        Route::get('/r', 'ReporteController@index');

        /**
         * Necesarias para el form de /r/param
         */
        Route::get('r/block/ajax-blocks/{idSector}', 'BlockController@ajaxBlocks');
        Route::get('r/block/ajax-get-limites/{data}', 'BlockController@ajaxGetLimites');
    });

    /**
     * Usuario logueado con permisos para mantención de datos
     */
    Route::group(array( 'before' => 'hasAccess:mantencion' ), function () {
        /**
         * Rutas para CRUD vías/trabajos/materiales
         */
        Route::resource('/m/sector', 'SectorController');
        Route::resource('/m/sector/{id}/blocks', 'SectorController@blocks');

        Route::resource('/m/block', 'BlockController');

        Route::resource('/m/trabajo', 'TrabajoController');
        Route::resource('/m/material', 'MaterialController');

        Route::resource('/m/material-retirado', 'MaterialRetiradoController');

        Route::resource('/m/grupo-trabajo', 'GrupoTrabajoController');

    });

});

/**
 * Errores
 */
//App::missing(function ($exception) {
//    return Response::view('404');
//});
App::error(function($exception, $code)
{
    switch ($code)
    {
        case 401:
            return Response::view('error', array('code' => 'Error 401', 'message' => 'Acceso no Autorizado.'), 401);

        case 403:
            return Response::view('error', array('code' => 'Error 403', 'message' => 'Ups...! La página solicitada no existe.'), 403);

        case 404:
            return Response::view('error', array('code' => 'Error 404', 'message' => 'Ups...! La página solicitada no existe.'), 404);

        case 405:
            return Response::view('error', array('code' => 'Error 405', 'message' => 'Ups...! La página solicitada no existe.'), 405);

        case 500:
            return Response::view('error', array('code' => 'Error 500', 'message' => 'Ups...! La página solicitada no existe.'), 500);

        default:
            return Response::view('error', array('code' => 'Error Desconocido '.$code, 'message' => 'Ups...! La página solicitada no existe.'), $code);
    }
});