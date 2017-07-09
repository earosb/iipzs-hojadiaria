<?php

/*
|--------------------------------------------------------------------------
| Rutas permiso reporte
|--------------------------------------------------------------------------
|
*/

/**
 * Rutas para generar reportes de trabajos
 */
Route::get('/r/param', 'ReporteController@param');
Route::get('/r', 'ReporteController@index');

/**
 * Necesarias para el form de /r/param
 */
Route::get('r/block/ajax-blocks/{idSector}', 'BlockController@ajaxBlocks');
Route::get('r/block/ajax-get-limites/{data}', 'BlockController@ajaxGetLimites');
