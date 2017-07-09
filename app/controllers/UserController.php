<?php

class UserController extends BaseController
{
    /**
     * @return \Illuminate\View\View
     */
    public function getProfile()
    {
        $user = Sentry::getUser();
        $throttle = Sentry::getThrottleProvider()->findByUserId($user->id);

        return View::make("user.profile")->with('throttle', $throttle);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function postProfile()
    {
        $rules = array(
            'password' => 'required|confirmed|min:6');

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return $this->redirectBackWithErrors($validator);
        }

        try {
            $user = Sentry::getUser();
            $newPassword = Input::get('password');
            $resetCode = $user->getResetPasswordCode();
            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($resetCode)) {
                // Attempt to reset the user password
                if ($user->attemptResetPassword($resetCode, $newPassword)) {
                    Alert::message('Contraseña modificada correctamente!', 'success');
                    return View::make('home');
                } else {
                    return Response::view('error.404');
                }
            } else {
                return Response::view('error.404');
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Response::view('error.404');
        }

    }

    /**
     * Despliega vista de login de usuario
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        //checkea si el usuario esta logueado
        if (Sentry::check()) {
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
    public function postLogin()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        // Credenciales
        $cmredenciales = array(
            'username' => $username,
            'password' => $password
        );
        try {
            $usuario = Sentry::authenticate($cmredenciales, false);

            if ($usuario) {
                Log::info('UserController::postLogin', [$usuario->username]);
                return Redirect::to('/r/param');
            }
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::to('login')->withErrors(array('login' => 'Nombre de usuario requerido.'));
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::to('login')->withErrors(array('login' => 'La contraseña es requerida.'));
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            return Redirect::to('login')->withErrors(array('login' => 'Contraseña incorrecta.'));
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('login')->withErrors(array('login' => 'Usuario no encontrado.'));
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return Redirect::to('login')->withErrors(array('login' => 'Usuario no activado.'));
        } // The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            return Redirect::to('login')->withErrors(array('login' => 'Usuario suspendido.'));
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            return Redirect::to('login')->withErrors(array('login' => 'Usuario desactivado/baneado.'));
        }

    }


    /**
     * Termina la sesión de un usuario.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        \Sentry::logout();
        return Redirect::to('/');
    }
}