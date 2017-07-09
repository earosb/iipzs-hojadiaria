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
Route::resource('carga', 'CargaController');
Route::get('depositos', 'DepositoController@showHistory');
Route::get('r/depositos', 'DepositoController@formReporte');
Route::get('r/depositos/result', 'DepositoController@getReporte');
