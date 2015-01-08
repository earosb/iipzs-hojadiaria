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

Route::get('login', function(){return View::make('login');});

Route::get('home', function(){return View::make('home');});

Route::resource('trabajos', 'TrabajosController');

Route::get('hola/{usuario}', function($usuario)
{
    return "Hola $usuario";
});

Route::get('/', function(){return View::make('hello');});
