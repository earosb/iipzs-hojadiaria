<?php

/*
|--------------------------------------------------------------------------
| Rutas permiso programar
|--------------------------------------------------------------------------
|
*/

/**
 * Rutas para programar trabajos
 */
Route::get('programar', 'ProgramarController@index');
Route::post('programar', 'ProgramarController@store');
Route::delete('programar/{id}', 'ProgramarController@destroy');
Route::put('programar/{id}', 'ProgramarController@update');
Route::post('programar/selected', 'ProgramarController@updateSelected');
Route::post('programar/merge', 'ProgramarController@merge');

Route::get('programar/getprograma', 'ProgramarController@getPrograma');

Route::get('grupos', 'GrupoTrabajoController@index');

Route::get('trabajo', 'TrabajoController@index');

Route::get('programar/download-app', 'ProgramarController@downloadApp');

Route::get('programar/connection_status', function () {
    return Response::json('ok');
});