<?php

/*
|--------------------------------------------------------------------------
| Rutas permiso superadmin
|--------------------------------------------------------------------------
|
*/

/**
 * Test para testear algo
 */
Route::get('admin/test', 'AdminController@test');

/**
 * Refactor campo tipo_via en tabla detalle_hoja_diaria.
 */
Route::get('admin/refactor_dhd/tipo_via', 'AdminController@RefactorDHDTipoVia');