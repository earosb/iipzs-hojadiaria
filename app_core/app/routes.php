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
Route::group(array('before' => 'auth'), function () {

    Route::get('/', 'HomeController@showWelcome');

    route::get('profile', 'UserController@getProfile');
    route::post('profile', 'UserController@postProfile');

    Route::get('logout', 'UserController@getLogout');

    /**
     * Usuario logueado con permiso hoja-diaria
     */
    Route::group(array('before' => 'hasAccess:hoja-diaria'), function () {

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

        /**
         * Materiales de cada trabajo
         */
        Route::get('/trabajo/{id}/materiales', 'TrabajoController@getMateriales');

    });

    /**
     * Usuario logueado con permisos de creación en form hoja diaria
     */
    Route::group(array('before' => 'hasAccess:editor'), function () {
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
    Route::group(array('before' => 'hasAccess:reporte'), function () {
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
     * Usuario logueado con permisos para form 2-3-4
     */
    Route::group(array('before' => 'hasAccess:form2-3-4'), function () {
        /**
         * Rutas para generar formulario
         */
        Route::get('/r/form', 'ReporteController@getForm');

        Route::post('/r/form', function () {
            if (Input::get('tipo_mantenimiento') == 'mayor') {
                $action = 'postFormMayor';
                return App::make('ReporteController')->$action();
            } elseif (Input::get('tipo_mantenimiento') == 'menor') {
                $action = 'postFormMenor';
                return App::make('ReporteController')->$action();
            }

            Alert::message('Error al seleccionar el tipo de mantenimiento!', 'danger');
            return Redirect::back();
        });

    });

    /**
     * Usuario logueado con permisos para mantención de datos
     */
    Route::group(array('before' => 'hasAccess:mantencion'), function () {
        /**
         * Rutas para CRUD vías/trabajos/materiales
         */
        Route::resource('/m/sector', 'SectorController');
        Route::resource('/m/sector/{id}/blocks', 'SectorController@blocks');

        Route::resource('/m/block', 'BlockController');

        Route::resource('/m/desviador', 'DesviadorController');

        Route::resource('/m/desvio', 'DesvioController');

        Route::resource('/m/trabajo', 'TrabajoController');

        Route::resource('/m/material', 'MaterialController');

        Route::resource('/m/material-retirado', 'MaterialRetiradoController');

        Route::resource('/m/grupo-trabajo', 'GrupoTrabajoController');

    });

    /**
     * Usuario logueado con permisos para programar trabajos
     */
    Route::group(array('before' => 'hasAccess:programar'), function () {
        /**
         * Rutas para planificar trabajos
         */
        Route::get('programar', 'ProgramarController@index');
        Route::post('programar', 'ProgramarController@store');
        Route::delete('programar/{id}', 'ProgramarController@destroy');
        Route::put('programar/{id}', 'ProgramarController@update');

        Route::get('programar/pdf', 'ProgramarController@pdf');

        Route::get('grupos', 'GrupoTrabajoController@index');

        Route::get('trabajo', 'TrabajoController@index');

        Route::get('causas', 'CausasController@index');
        Route::post('causas', 'CausasController@store');
    });

    Route::get('programar2', function () {
        //\Debugbar::disable();
        $trabajos = Trabajo::lists('nombre', 'id');
        $grupos = GrupoTrabajo::lists('base', 'id');
        return View::make('programar.index-angular')
            ->with('trabajos', $trabajos)
            ->with('grupos', $grupos);
    });

});


/**
 * Manejo de Errores
 */
if (!Config::get('app.debug')) {

    App::missing(function ($exception) {
        return Response::view('error', array(
            'code' => 'Error 404',
            'exception' => $exception->getMessage(),
            'message' => 'Ups...! La página solicitada no existe.'),
            404);
    });

    App::error(function ($exception, $code) {

        switch ($code) {
            case 403:
                $message = trans('all.error.403');
                break;
            case 404:
                $message = trans('all.error.404');
                break;
            case 500:
                $message = trans('all.error.500');
                break;
            default:
                $message = trans('all.error.default');
        }

        return Response::view('error', array(
            'code' => 'Error ' . $code,
            'exception' => $exception->getMessage(),
            'message' => $message),
            $code);
    });

}

/**
 * Rutas para tareas de super administrador 8)
 */
Route::group(array('before' => 'hasAccess:superadmin'), function () {

    /**
     * Test para testear algo
     */
    Route::get('admin/test', 'AdminController@test');

    /**
     * Refactor campo tipo_via en tabla detalle_hoja_diaria.
     */
    Route::get('admin/refactor_dhd/tipo_via', 'AdminController@RefactorDHDTipoVia');

});

/**
 * API v1
 */
Route::group(array('prefix' => 'api/v1'), function () {

    /**
     * Login
     */
    Route::post('login', 'APIv1Controller@login');

    Route::group(array('before' => 'auth_api'), function(){
        
        /**
         * Trabajos a granel
         */
        Route::get('trabajos', 'APIv1Controller@trabajos');

    });


});