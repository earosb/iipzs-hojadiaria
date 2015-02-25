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
        Route::post('/desviador/ajax-create', 'DesviadorController@ajaxCreate');
        Route::get('/desviador/ajax-desviadores/{blockId}', 'DesviadorController@ajaxDesviadores');
        Route::get('/desviador/get-desviadores-sur/{id}', 'DesviadorController@getDesviadoresSur');

        /**
         * Desvío
         */
        Route::post('desvio', 'DesvioController@store');

        /**
         * Material Retirado
         */
        Route::post('material-retirado', 'MaterialRetiradoController@store');
        Route::get('material-retirado/ajax-list', 'MaterialRetiradoController@ajaxList');

        /**
         * Material Colocado
         */
        Route::post('material-colocado', 'MaterialController@store');

        /**
         * Trabajos
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
        //Route::resource('/m/block/{id}/edit', 'BlockController@blocks');
        //Route::resource('/m/block/{id}/vias', 'BlockController@blocks');

        Route::resource('/m/trabajo', 'TrabajoController');
        Route::resource('/m/material', 'MaterialController');

    });

});

/**
 * Errores
 */
App::missing(function ($exception) {
    return Response::view('error.404');
});