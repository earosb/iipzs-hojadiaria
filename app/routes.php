<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Admin de Usuarios
 */
Route::get('login', 'UserController@getLogin');

Route::post('login', 'UserController@postLogin');

/**
 * Usuario logueado sin permisos especiales
 */
Route::group(array('before' => 'auth'), function(){

	Route::get('/', function(){return View::make('home');});

	Route::get('logout', 'UserController@getLogout');
	
});

/**
 * Usuario logueado con permisos para de admin
 */
Route::group(array('before' => 'auth|tienePermisos:admin'), function(){

	/**
	 * Hola Diaria
	 */
	Route::resource('hd', 'HojaDiariaController');

	/**
	 * Block
	 */
	Route::resource('block', 'BlockController');
	Route::get('/block/ajax-blocks/{idSector}', 'BlockController@ajaxBlocks');
	Route::get('/block/ajax-block-todo/{idBlock}', 'BlockController@ajaxBlockTodo');
	Route::get('/block/ajax-get-limites/{data}', 'BlockController@ajaxGetLimites');
	
	/**
	* Desviador
	*/
	Route::post('/desviador/ajax-create', 'DesviadorController@ajaxCreate');
	Route::get('/desviador/ajax-desviadores/{blockId}', 'DesviadorController@ajaxDesviadores');

	/**
	* Desvío
	*/
	Route::post('/desvio/ajax-create', 'DesvioController@ajaxCreate');


});

/**
 * Errores
 */
App::missing(function($exception){
	return Response::view('error.404');
});

