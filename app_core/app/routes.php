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
Route::group([ 'before' => 'auth' ], function () {

    Route::get('/', 'HomeController@showWelcome');

    route::get('profile', 'UserController@getProfile');
    route::post('profile', 'UserController@postProfile');

    Route::get('logout', 'UserController@getLogout');

    /**
     * Usuario logueado con permiso hoja-diaria
     */
    Route::group([ 'before' => 'hasAccess:hoja-diaria' ], function () {
        require __DIR__ . '/routes/hoja-diaria.php';
    });

    /**
     * Usuario logueado con permisos de creación en form hoja diaria
     */
    Route::group([ 'before' => 'hasAccess:editor' ], function () {
        require __DIR__ . '/routes/editor.php';
    });

    /**
     * Usuario logueado con permisos para consultas/reportes
     */
    Route::group([ 'before' => 'hasAccess:reporte' ], function () {
        require __DIR__ . '/routes/reporte.php';
    });

    /**
     * Usuario logueado con permisos para form 2-3-4
     */
    Route::group([ 'before' => 'hasAccess:form2-3-4' ], function () {
        require __DIR__ . '/routes/form2-3-4.php';
    });

    /**
     * Usuario logueado con permisos para mantención de datos
     */
    Route::group([ 'before' => 'hasAccess:mantencion' ], function () {
        require __DIR__ . '/routes/mantencion.php';
    });

    /**
     * Usuario logueado con permisos para programar trabajos
     */
    Route::group([ 'before' => 'hasAccess:programar' ], function () {
        require __DIR__ . '/routes/programar.php';
    });

});

/**
 * Rutas para tareas de super administrador 8)
 */
Route::group([ 'before' => 'hasAccess:superadmin' ], function () {
    require __DIR__ . '/routes/superadmin.php';
});

/**
 * API v1
 */
Route::group([ 'prefix' => 'api/v1' ], function () {
    require __DIR__ . '/routes/apiv1.php';
});

/**
 * API v2
 */
Route::group([ 'prefix' => 'api/v2' ], function () {
    require __DIR__ . '/routes/apiv2.php';
});

/**
 * Descarga de manuales
 */
Route::group([ 'prefix' => 'manual' ], function () {
    Route::get('admin', function () {
        return Response::download(storage_path('static/manual-mantencion.pdf'));
    });
    Route::get('programar', function () {
        return Response::download(storage_path('static/manual-programar.pdf'));
    });
    Route::get('android', function () {
        return Response::download(storage_path('static/manual-android.pdf'));
    });
});

/**
 * Manejo de Errores
 */
if ( ! Config::get('app.debug')) {

    App::missing(function ($exception) {
        return Response::view('error', [
            'code'      => 'Error 404',
            'exception' => $exception->getMessage(),
            'message'   => 'Ups...! La página solicitada no existe.'
        ], 404);
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

        return Response::view('error', [
            'code'      => 'Error ' . $code,
            'exception' => $exception->getMessage(),
            'message'   => $message
        ], $code);
    });

}