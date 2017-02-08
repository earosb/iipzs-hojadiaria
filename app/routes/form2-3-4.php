<?php

/*
|--------------------------------------------------------------------------
| Rutas permiso form2-3-4
|--------------------------------------------------------------------------
|
*/

/**
 * Rutas para generar formulario
 */
Route::get('/r/form', 'ReporteController@getForm');

Route::post('/r/form', function () {
    if (Input::get('tipo_mantenimiento') == 'mayor') {
        //$action = 'postFormMayor';
        $action = 'postFormMayorSimple';

        return App::make('ReporteController')->$action();
    } elseif (Input::get('tipo_mantenimiento') == 'menor') {
        $action = 'postFormMenor';

        return App::make('ReporteController')->$action();
    }

    Alert::message('Error al seleccionar el tipo de mantenimiento!', 'danger');

    return Redirect::back();
});