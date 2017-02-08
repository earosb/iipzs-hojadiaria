<?php

/*
|--------------------------------------------------------------------------
| Rutas permiso editor
|--------------------------------------------------------------------------
|
*/

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