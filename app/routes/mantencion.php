<?php

/*
|--------------------------------------------------------------------------
| Rutas permiso mantencion
|--------------------------------------------------------------------------
|
*/

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

Route::resource('/m/deposito', 'DepositoController');

Route::resource('/m/carga', 'CargaController',
    array('only' => array('index', 'create', 'store', 'destroy')));
