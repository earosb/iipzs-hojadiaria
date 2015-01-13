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

/* Admin de Usuarios */
Route::post('/login', 'UserController@postLogin');
Route::get('/logout', 'UserController@getLogout');

Route::resource('t', 'TrabajoEjecutadoController');
Route::resource('hd', 'HojaDiariaController');
// Route::resource('trabajadors', 'TrabajadorsController');
Route::resource('block', 'BlocksController');

Route::get('/block/ajax-blocks/{idSector}', 'BlocksController@ajaxBlocks');
Route::get('/block/ajax-block-todo/{idBlock}', 'BlocksController@ajaxBlockTodo');

Route::get('hola/{usuario}', function($usuario)
{
    return "Hola $usuario";
});

Route::get('/', function(){return View::make('home');});
//Route::get('/', 'UserController@getLogin');

