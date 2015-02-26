<?php

class UserController extends BaseController {

    /**
     * @return $this
     */
    public function getProfile() {

        $user = Sentry::getUser();
        $throttle = Sentry::getThrottleProvider()->findByUserId($user->id);

        return View::make("user.profile")->with('throttle', $throttle);
    }

    /**
     * @return $this
     */
    public function postProfile() {

        $rules = array(
            'password' => 'required|confirmed|min:6' );

        $validator = Validator::make(Input::all(), $rules);

        if ( $validator->fails() ) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            $user = Sentry::getUser();
            $newPassword = Input::get('password');
            $resetCode = $user->getResetPasswordCode();
            // Check if the reset password code is valid
            if ( $user->checkResetPasswordCode($resetCode) ) {
                // Attempt to reset the user password
                if ( $user->attemptResetPassword($resetCode, $newPassword) ) {
                    return View::make('home')->with('msg', 'Contraseña modificada correctamente!');
                } else {
                    return Response::view('error.404');
                }
            } else {
                return Response::view('error.404');
            }
        } catch ( Cartalyst\Sentry\Users\UserNotFoundException $e ) {
            return Response::view('error.404');
        }

    }

    /**
     * Despliega vista de login de usuario
     *
     * @return View
     */
    public function getLogin() {
        //checkea si el usuario esta logueado
        if ( \Sentry::check() ) {
            // echo "usuario logueado";
            return View::make("home");
        } else {
            return View::make("user.login");
        }
    }

    /**
     * Recibe los datos para login de usuario
     *
     * @return string
     */
    public function postLogin() {
        $username = Input::get('username');
        $password = Input::get('password');

        // Credenciales
        $cmredenciales = array(
            'username' => $username,
            'password' => $password
        );
        try {
            $usuario = Sentry::authenticate($cmredenciales, false);

            if ( $usuario ) {
                return Redirect::to('/');
            }
        } catch ( Cartalyst\Sentry\Users\LoginRequiredException $e ) {
            return Redirect::to('login')->withErrors(array( 'login' => 'Nombre de usuario requerido.' ));
        } catch ( Cartalyst\Sentry\Users\PasswordRequiredException $e ) {
            return Redirect::to('login')->withErrors(array( 'login' => 'La Contraseña es requerida.' ));
        } catch ( Cartalyst\Sentry\Users\WrongPasswordException $e ) {
            return Redirect::to('login')->withErrors(array( 'login' => 'Contraseña incorrecta, intentelo nuevamente.' ));
        } catch ( Cartalyst\Sentry\Users\UserNotFoundException $e ) {
            return Redirect::to('login')->withErrors(array( 'login' => 'Usuario no encontrado.' ));
        } catch ( Cartalyst\Sentry\Users\UserNotActivatedException $e ) {
            return Redirect::to('login')->withErrors(array( 'login' => 'Usuario no activado.' ));
        } // The following is only required if the throttling is enabled
        catch ( Cartalyst\Sentry\Throttling\UserSuspendedException $e ) {
            return Redirect::to('login')->withErrors(array( 'login' => 'Usuario suspendido.' ));
        } catch ( Cartalyst\Sentry\Throttling\UserBannedException $e ) {
            return Redirect::to('login')->withErrors(array( 'login' => 'Usuario Baneado.' ));
        }

    }


    /**
     * Termina la sesión de un usuario.
     *
     * @return Response
     */
    public function getLogout() {
        \Sentry::logout();
        return Redirect::to('/');
    }
}