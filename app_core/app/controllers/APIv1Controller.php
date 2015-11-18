<?php

class APIv1Controller extends \BaseController
{
    /**
     * GET /api/v1/trabajos
     *
     * @return Response
     */
    public function trabajos()
    {
        try {
            $trabajos = Trabajo::orderby('nombre')
                ->get(array('id as remote_id', 'nombre', 'unidad'));
            return Response::json($trabajos);
        } catch (Exception $e) {
            return Response::json(['error' => true, 'msg' => 'Se produjo un error en la base de datos']);
        }
    }

    /**
     * POST /api/v1/login
     *
     * @return Response
     */
    public function login()
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
                $token = bin2hex(openssl_random_pseudo_bytes(16));

                $user = Sentry::getUser();
                $user->token_api = $token;
                $user->save();

                return Response::json(['error' => 'false',
                    'user' => $user]);
            }
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Response::json(['error' => 'true', 'msg' => 'Nombre de usuario requerido.']);
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Response::json(['error' => 'true', 'msg' => 'La Contraseña es requerida.']);
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            return Response::json(['error' => 'true', 'msg' => 'Contraseña incorrecta.']);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Response::json(['error' => 'true', 'msg' => 'Usuario no encontrado.']);
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return Response::json(['error' => 'true', 'msg' => 'Usuario no activado.']);
        } // The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            return Response::json(['error' => 'true', 'msg' => 'Usuario suspendido.']);
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            return Response::json(['error' => 'true', 'msg' => 'Usuario Baneado.']);
        }
    }

    /**
     * POST /api/v1/programar
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        try {
            $trabajos = json_decode(Input::get('trabajos'));
            foreach ($trabajos as $p) {
                $programar = new Programar();
                $programar->causa = $p->causa;
                $programar->trabajo_id = $p->trabajo_id;
                $programar->km_inicio = $p->km_inicio;
                $programar->km_termino = $p->km_termino;
                $programar->cantidad = $p->cantidad;
                $programar->observaciones = $p->obs;
                $programar->save();
            }
            return Response::json(['error' => false]);
        } catch (Exception $e) {
            return Response::json(['error' => true, 'msg' => 'Se produjo un error en la base de datos']);
        }
    }
}
