<?php

/*
|--------------------------------------------------------------------------
| Rutas permiso hoja-diaria
|--------------------------------------------------------------------------
|
*/

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
