<?php

/*
|--------------------------------------------------------------------------
| Rutas para APIv2
|--------------------------------------------------------------------------
|
*/

/**
 * Login
 */
Route::post('login', 'APIv2Controller@login');

/**
 * Trabajos a granel
 * Sólo mantenimiento menor y mayor
 */
Route::get('trabajos', 'APIv2Controller@trabajos');

/**
 * Almacenar trabajos para programar
 */
Route::post('programar', 'APIv2Controller@store');

