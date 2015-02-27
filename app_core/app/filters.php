<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|


App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});
*/

/**
 * Sentry Filter
 * Filtro básico de autentificación,
 * sólo para saber si el usuario está logueado
 * @return Redirect si no está logueado al login
 */

Route::filter('auth', function () {

    if ( !Sentry::check() )
        return Redirect::guest('login');

});

/**
 * Filtro de permisos
 * Verifica que un usuario tiene un permiso
 * @param $route
 * @param $request
 * @param $value string permiso
 * @return View 404
 */
Route::filter('hasAccess', function ($route, $request, $value) {

    try {
        $user = Sentry::getUser();

        if ( !$user->hasAccess($value) ) {
            App::abort(401);
        }
    } catch ( Cartalyst\Sentry\Users\UserNotFoundException $e ) {
        return Response::view('error', array('code' => 'Error Desconocido', 'message' => 'Usuario no encontrado.'), 401);
    }

});


/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|


Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		return Redirect::guest('login');
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});	*/

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|


Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});	*/
/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if ( Session::token() !== Input::get('_token') ) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
