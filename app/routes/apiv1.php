<?php

/*
|--------------------------------------------------------------------------
| Rutas para APIv1
|--------------------------------------------------------------------------
|
*/

/**
 * Login
 */
Route::post('login', 'APIv1Controller@login');

Route::group([ 'before' => 'auth_api' ], function () {
    /**
     * Trabajos a granel
     */
    Route::get('trabajos', 'APIv1Controller@trabajos');

    /**
     * Almacenar trabajos para programar
     */
    Route::post('programar', 'APIv1Controller@store');

});