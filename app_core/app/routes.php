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
//        Route::post('/r/form', 'ReporteController@postForm');
        Route::post('/r/form', function () {
            if (Input::get('action') == 'mayor') {
                $action = 'postFormMayor';
                return App::make('ReporteController')->$action();
            } elseif (Input::get('action') == 'menor') {
                $action = 'postFormMenor';
                return App::make('ReporteController')->$action();
            }
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

//        $username = 'evalo'; //Sentry::getUser()->username;
//        Mail::send('emails.error',
//            array(
//                'user' => $username,
//                'code' => $code,
//                'message' => $exception->getMessage(),
//                'exception' => $exception,
//            ),
//            function ($message) use ($username) {
//                $message->to('webmaster@icilicafalpzs.cl', $username)
//                    ->subject('I-I PZS ERROR');
//            });

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

//Route::get('test', function () {


//    $trabajos = DB::select("
//        SELECT t.nombre AS partida, t.unidad, sum(dhd.cantidad) AS cantidad
//            FROM hoja_diaria hd, detalle_hoja_diaria dhd, trabajo t, block b
//            WHERE hd.id = dhd.hoja_diaria_id
//                AND dhd.trabajo_id = t.id
//                AND dhd.block_id = b.id
//                AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '498800' AND dhd.km_inicio < '625500' )
//                AND hd.fecha BETWEEN '2015-03-01 00:00:00' AND '2015-03-31 23:59:59'
//            GROUP BY t.id");

//    $trabajos = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
//        ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
//        ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
//        ->whereBetween('fecha', array('2015-03-01 00:00:00', '2015-03-31 23:59:59'), 'and')
//        ->where('detalle_hoja_diaria.km_inicio', '>=', '498800')
//        ->where('detalle_hoja_diaria.km_inicio', '<', '625500')
//        ->select('trabajo.nombre', 'trabajo.unidad', DB::raw('SUM(detalle_hoja_diaria.cantidad) as cantidad'))
//        ->groupBy('trabajo.nombre')
//        ->get();
//
//    return $trabajos;
//});

//        SELECT t.nombre AS partida, t.unidad, sum(dhd.cantidad) AS cantidad
//        FROM hoja_diaria hd, detalle_hoja_diaria dhd, trabajo t, block b
//        WHERE hd.id = dhd.hoja_diaria_id
//        AND dhd.trabajo_id = t.id
//        AND dhd.block_id = b.id
//        AND hd.id  in (select  dhd.hoja_diaria_id from detalle_hoja_diaria dhd where dhd.km_inicio >= '498800' AND dhd.km_inicio < '625500' )
//              AND hd.fecha BETWEEN '2015-03-01 00:00:00' AND '2015-03-31 23:59:59'
//        GROUP BY t.id;