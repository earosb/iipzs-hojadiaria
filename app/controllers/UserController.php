<?php 

class UserController extends BaseController {


    /**
     * Despliega vista de login de usuario
     * 
     * @return View
     */
    public function getLogin()
    {
        //checkea si el usuario esta logueado
        if (\Sentry::check()){
            echo "usuario logueado";
            return View::make("home");
        }else{
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
        try
        {

            $username = Input::get('username');
            $password = Input::get('password');

            // Credenciales
            $cmredenciales = array(
                'username'	=> $username,
                'password'	=> $password
            );

            // Autentifica al usuario
            /*
                para mantener al usuario autentificado de manera
                permanente se usa authenticateAndRemember

                sacado de 
                https://cartalyst.com/manual/sentry#example
            */
            $usuario = Sentry::authenticate($cmredenciales, false);
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo 'Nombre de usuario requerido.';
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo 'La Contraseña es requerida.';
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            echo 'Contraseña incorrecta, intentelo nuevamente.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'Usuario no encontrado.';
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            echo 'Usuario no activado.';
        }

        // The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            echo 'Usuario suspendido.';
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            echo 'Usuario Baneado.';
        }

   

        echo "FIN";

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