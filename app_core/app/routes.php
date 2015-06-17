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

    Route::get('test', function () {
        $sector = Sector::find(1);
        $year = 2015;
        $mes = 5;
        $tipoTrabajo = 'mayor';

        $desdeQuery = date('Y-m-01', strtotime($year . '-' . $mes . '-01'));
        $hastaQuery = date('Y-m-t', strtotime($year . '-' . $mes . '-01'));

        $blocks = $sector->blocks;

        $trabajosMeta['sector'] = $sector->nombre;
        $trabajosMeta['fecha'] = $mes . ' - ' . $year;

        $partidas = Trabajo::where('trabajo.es_oficial', '=', '1', 'and')
            ->where('tipo_mantenimiento.cod', '=', $tipoTrabajo)
            ->join('tipo_mantenimiento', 'trabajo.tipo_mantenimiento_id', '=', 'tipo_mantenimiento.id')
            ->select('trabajo.id', 'trabajo.nombre', 'trabajo.unidad', 'trabajo.valor')
            ->get();

        foreach ($partidas as $partida) {
            $trabajos = array();
            $trabajosMeta['nombre'] = $partida->nombre;
            foreach ($blocks as $block) {
                $trabajosQuery = HojaDiaria::join('detalle_hoja_diaria', 'hoja_diaria.id', '=', 'detalle_hoja_diaria.hoja_diaria_id')
                    ->join('trabajo', 'detalle_hoja_diaria.trabajo_id', '=', 'trabajo.id')
                    ->join('block', 'detalle_hoja_diaria.block_id', '=', 'block.id')
                    ->join('grupo_trabajo', 'hoja_diaria.grupo_trabajo_id', '=', 'grupo_trabajo.id')
                    ->whereBetween('fecha', array($desdeQuery, $hastaQuery), 'and')
                    ->where('block.id', '=', $block->id)
                    ->where('trabajo.id', '=', $partida->id)
                    ->select(
                        array(
                            'block.id',
                            'block.estacion',
                            'detalle_hoja_diaria.km_inicio',
                            'detalle_hoja_diaria.km_termino',
                            'detalle_hoja_diaria.desviador_id',
                            'detalle_hoja_diaria.desvio_id',
                            'trabajo.nombre',
                            'trabajo.unidad',
                            'detalle_hoja_diaria.cantidad'))
                    ->orderBy('detalle_hoja_diaria.km_inicio')
                    ->get();
                if (!$trabajosQuery->isEmpty()) {
                    $trabajos[] = $trabajosQuery;
                    $trabajosMeta['block'][] = $block->estacion;
                }
            }
            if (!empty($trabajos)) {
                Excel::create($trabajosMeta['nombre'], function ($excel) use ($trabajosMeta, $trabajos) {
                    foreach ($trabajos as $index => $t) {
                        $trabajosMeta['total'] = 0;
                        foreach ($t as $cont => $aux) {
                            $trabajosMeta['total'] += $aux->cantidad;
                        }

                        $excel->sheet($trabajosMeta['block'][$index], function ($sheet) use ($trabajosMeta, $t, $index) {
                            $sheet->setStyle(array('font' => array('name' => 'Arial', 'size' => 12)));
                            $sheet->setAutoSize(true);
                            $sheet->loadView('reporte.generador')
                                ->with('block', $trabajosMeta['block'][$index])
                                ->with('trabajosMeta', $trabajosMeta)
                                ->with('trabajos', $t);
                        });
                    }
                })->store('xls', public_path('excel/test'));
            }
            unset($trabajos);
        }
        return 'done';
    });

}